<?php
namespace App\Http\Controllers\Backend\Sync\Leangoo;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use function GuzzleHttp\json_decode;

/**
 * Class TeamController
 */
class ProjectController extends Controller
{

    /**
     *
     * @param UserRepositoryContract $users            
     * @param RoleRepositoryContract $roles            
     */
    public function __construct()
    {}

    /**
     *
     * @param ManageUserRequest $request            
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function get(Request $request, $id)
    {
        $un = $request->get('un');
        $pwd = $request->get('pwd');
        
        $sync = new SyncHelper($un);
        $projDetail = $sync->login($un, $pwd)->getProjectDetail($id);

        return response()->json($projDetail);
    }
    
}

class SyncHelper
{
    protected $cookie_jar = '';
    
    function __construct($symbol) {
        if (is_null($symbol)){
            $symbol = rand();
        }
        $this->cookie_jar = storage_path('app/public/cookies/' . $symbol . '.cookie');
    }
    
    function login($email, $pswd){
        $url = 'https://www.leangoo.com/kanban/login/go';
        $data = [
            'email' => $email,
            'pwd' => $pswd,
            'loginRemPwdVal' => TRUE,
            'from_page' => '%2Fproject%2Fgo%2F1633'
        ];
        
        $this->curl_post($url, $data, [
            CURLOPT_COOKIEJAR => $this->cookie_jar,
            CURLOPT_COOKIEFILE => $this->cookie_jar,
        ]);
        return $this;
    }
    
    function getProjectDetail($projId) {
        $url = 'https://www.leangoo.com/kanban/project/go/' . $projId;
        
        $html = $this->curl_get($url, [], [
            CURLOPT_COOKIEJAR => $this->cookie_jar,
            CURLOPT_COOKIEFILE => $this->cookie_jar,
        ]);
        
        preg_match_all('/<h1 class="break-word">(.*)<\/h1>/i', $html, $results);
        $project_name = $results[1][0];
        
        preg_match_all('/loadProjectMember\((.*)\)/i', $html, $results);
        $members = json_decode($results[1][0]);
        return [
            'project' => [
                'name' => $project_name
            ],
            'members' => $members
        ];
    }
    
    /**
     * Send a POST requst using cURL
     * @param string $url to request
     * @param array $post values to send
     * @param array $options for cURL
     * @return string
     */
    function curl_post($url, array $post = NULL, array $options = array())
    {
        $defaults = array(
            CURLOPT_POST => 1,
            CURLOPT_HEADER => 0,
            CURLOPT_URL => $url,
            CURLOPT_FRESH_CONNECT => 1,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_FORBID_REUSE => 1,
            CURLOPT_TIMEOUT => 4,
            CURLOPT_POSTFIELDS => http_build_query($post)
        );
    
        $ch = curl_init();
        curl_setopt_array($ch, ($options + $defaults));
        if( ! $result = curl_exec($ch))
        {
            //trigger_error(curl_error($ch));
        }
        curl_close($ch);
        return $result;
    }
    
    /**
     * Send a GET requst using cURL
     * @param string $url to request
     * @param array $get values to send
     * @param array $options for cURL
     * @return string
     */
    function curl_get($url, array $get = NULL, array $options = array())
    {
        $defaults = array(
            CURLOPT_URL => $url. (!is_null($get) ? (strpos($url, '?') === FALSE ? '?' : ''). http_build_query($get) : ''),
            CURLOPT_HEADER => 0,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_TIMEOUT => 4
        );
         
        $ch = curl_init();
        curl_setopt_array($ch, ($options + $defaults));
        if( ! $result = curl_exec($ch))
        {
            //trigger_error(curl_error($ch));
        }
        curl_close($ch);
        return $result;
    }
}
