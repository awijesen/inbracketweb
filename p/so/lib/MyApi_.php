<?php
class MyApi
{
    protected $db;
    protected $show_logs;

    public function __construct($db, $show_logs = true)
    {
        $this->db = $db;
        $this->show_logs = $show_logs;
    }

    private function getCredentials()
    {
        try {
            $skey = 'creds';
            $stmt = $this->db->prepare("SELECT svalues FROM settings WHERE skey=?");
            $stmt->bind_param('s', $skey);      
            $stmt->execute();   
            $stmt->bind_result($creds_json);
            $stmt->fetch();        
            return json_decode($creds_json, true);
        } catch(\Exception $e) {
            // do nothing
        }
        return null;
    }

    public function updatePicker($post)
    {
        if(is_array($post) && count($post) > 0)
        {
            $picker = $post['cboPicker'];
            if(!empty($picker)) {
                $LineIds = [];                
                foreach($post as $k => $v) 
                {
                    if(substr($k, 0, 10) == 'chkLineId_')
                    {
                        $LineIds[] = str_replace("chkLineId_", "", $k);
                    }
                }
                if(is_array($LineIds) && count($LineIds) > 0)
                {
                    $LineIds_str = implode("," , $LineIds); 
                    $stmt = $this->db->prepare("UPDATE sales_order SET Picker = ? WHERE Picker = 'Schedule' AND LineId IN (" . $LineIds_str . ")");
                    $stmt->bind_param('s', $picker);    
                    $update = $stmt->execute();
                }
            }
        }
    }

    public function getData($search = "", $limit = 10, $offset = 0)
    {
        /*FROM sales_order WHERE Picker IS NULL"*/
        $response = [];
        try {
            // total records
            $sql = mysqli_query($this->db, "SELECT LineId FROM sales_order");
            $sql_count = mysqli_num_rows($sql);
            // where
            $query = "SELECT * FROM sales_order WHERE (
                SO LIKE '%". $search . "%' 
                OR Customer LIKE '%". $search . "%' 
                OR Reference LIKE '%". $search . "%' 
                OR Shipday LIKE '%". $search ."%'
                OR createdby LIKE '%". $search ."%'
                OR Picker LIKE '%". $search ."%'
                OR Code LIKE '%". $search ."%'
            )";
            // order
            $order_index = $_POST['order'][0]['column'];
            $order_field = $_POST['columns'][$order_index]['data'];
            $order_ascdesc = $_POST['order'][0]['dir'];
            $order = " ORDER BY ".$order_field." ".$order_ascdesc;
            // data    
            $sql_data = mysqli_query($this->db, $query.$order . " LIMIT ". $limit . " OFFSET ".$offset);
            $sql_filter = mysqli_query($this->db, $query);
            $sql_filter_count = mysqli_num_rows($sql_filter);

            $data = mysqli_fetch_all($sql_data, MYSQLI_ASSOC);
            $response = [
                'draw' => $_POST['draw'],
                'recordsTotal'=> $sql_count,
                'recordsFiltered'=> $sql_filter_count,
                'data' => $data
            ];

            /*
            $stmt = $this->db->prepare("SELECT                                 
                LineId, 
                SortCodeDescription, 
                SO, 
                Customer, 
                Reference, 
                ProcessedDate, 
                CreatedOn, 
                Shipday, 
                createdby, 
                value, 
                IFNULL(Picker, 'Schedule') as Picker, 
                Code, 
                Description, 
                OrdQty
                FROM sales_order WHERE ? LIMIT ? OFFSET ?"
            );
            $stmt->bind_param("sdd", $where, $limit, $offset);
            $stmt->execute();   
            $result = $stmt->get_result();
            $response = [
                'draw' => $_POST['draw'],
                'recordsTotal'=> $sql_count,
                'recordsFiltered'=> $sql_filter_count,
                'data' => $result->fetch_all(MYSQLI_ASSOC)
            ];
            */
        } catch(\Exception $e) {
            // do nothing
        }
        return json_encode($response);
    }

    /********************************** CREDENTIALS *************************************************/
    private function getTokens($credentials) // return array of tokens or errors
    {
        $tokens = [];

        try {
            $skey = 'tokens';
            $stmt = $this->db->prepare("SELECT svalues FROM settings WHERE skey=?");
            $stmt->bind_param('s', $skey);    
            $stmt->execute();   
            $stmt->bind_result($tokens_json);
            $stmt->fetch();  
        } catch (\Exception $e) {
            return [
                'error' => true,
                'origin' => 'local',
                'response' => $e->getMessage()
            ];
        }

        if(!empty($tokens_json)) {
            try {
                $tokens_arr = json_decode($tokens_json, true);
                if(is_array($tokens_arr) && count($tokens_arr) > 0) {
                    if(
                        !empty($tokens_arr['access_token']) && 
                        !empty($tokens_arr['expires_in']) && 
                        !empty($tokens_arr['token_type']) && 
                        !empty($tokens_arr['refresh_token']) &&
                        !empty($tokens_arr['expiration_time'])  
                    ) {
                        if( intval($tokens_arr['expiration_time']) <= (time() - 5) ) { // do refresh token
                            $tokens = $this->doRefreshToken($credentials, $tokens_arr['refresh_token']);
                        } else {
                            $tokens = $tokens_arr;
                        }
                    }
                } else {
                    $tokens = [];
                }
            } catch (\Exception $e) {
                $tokens = [];
            }
        }
        
        if(empty($tokens)) {
            return $this->doAuth($credentials);
        } else {
            return $tokens;
        }
    }

    private function doAuth($credentials) // return array of tokens or errors
    {
        $params=[
            'username' => $credentials['username'], 
            'password' => $credentials['password'], 
            'database' => $credentials['database'],
            'keys' => $credentials['keys'],
            'Connection-Type' => $credentials['Connection-Type'],
            'grant_type' => 'password'
        ];

        $defaults = array(
            CURLOPT_URL => 'https://remote.grwills.com.au:443/WebAPI/API/Bearer',
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($params),
            CURLOPT_RETURNTRANSFER => true
        );   

        $ch = curl_init();
        curl_setopt_array($ch, $defaults);
        $response = curl_exec($ch);
        curl_close($ch);

        if($response === false) {
            return [
                'error' => true,
                'origin' => 'local',
                'response' => url_error($ch)
            ];
        } else {
            try {
                // save or update table tokens
                $new_tokens_arr = json_decode($response, true);
                if(
                    !empty($new_tokens_arr['access_token']) && 
                    !empty($new_tokens_arr['expires_in']) && 
                    !empty($new_tokens_arr['token_type']) && 
                    !empty($new_tokens_arr['refresh_token'])  
                ) {
                    $new_tokens_arr['expiration_time'] = time() + intval($new_tokens_arr['expires_in']);
                    // save to table tokens
                    $stored = $this->doSaveTokens($credentials, json_encode($new_tokens_arr));
                    return $new_tokens_arr;
                } else {
                    return [
                        'error' => true,
                        'origin' => 'local',
                        'response' => 'Not a valid response'
                    ];
                }
            } catch(\Exception $e) {
                return [
                    'error' => true,
                    'origin' => 'local',
                    'response' => $e->getMessage()
                ];
            }
        }
    }

    private function doSaveTokens($credentials, $new_tokens_json)
    {
        try {
            $skey = 'tokens';
            $stmt = $this->db->prepare("SELECT svalues FROM settings WHERE skey=?");
            $stmt->bind_param('s', $skey);      
            $stmt->execute();   
            $stmt->bind_result($tokens_json);
            $stmt->fetch();        
            if(!empty($tokens_json)) { // update
                $stmt = $this->db->prepare("UPDATE settings SET svalues=? WHERE skey=?");            
                $stmt->bind_param('ss', $new_tokens_json, $skey);    
                $save = $stmt->execute();   
            } else { // insert
                $stmt = $this->db->prepare("INSERT INTO settings (skey, svalues) VALUES (?, ?)");
                $stmt->bind_param('ss', $skey, $new_tokens_json);    
                $save = $stmt->execute();   
            }
        } catch(\Exception $e) {
            // do nothing
        }
    }

    private function doRefreshToken($credentials, $refresh_token) // return array of tokens or errors
    {
        $params=[
            'grant_type' => 'refresh_token',
            'refresh_token' => $refresh_token,
            'database'=> $credentials['database'],
            'keys' => $credentials['keys'],
        ];

        $defaults = array(
            CURLOPT_URL => 'https://remote.grwills.com.au:443/WebAPI/API/Bearer',
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($params),
            CURLOPT_RETURNTRANSFER => true
        );        
        
        $ch = curl_init();
        curl_setopt_array($ch, $defaults);
        $response = curl_exec($ch);
        curl_close($ch);

        if($response === false) {
            return [
                'error' => true,
                'origin' => 'local',
                'response' => curl_error($ch)
            ];
        } else {
            try {
                // save or update table tokens
                $new_tokens_arr = json_decode($response, true);
                if(
                    !empty($new_tokens_arr['access_token']) && 
                    !empty($new_tokens_arr['expires_in']) && 
                    !empty($new_tokens_arr['token_type']) && 
                    !empty($new_tokens_arr['refresh_token'])  
                ) {
                    $new_tokens_arr['expiration_time'] = time() + intval($new_tokens_arr['expires_in']);
                    // save to table tokens
                    $stored = $this->doSaveTokens($credentials, json_encode($new_tokens_arr));
                    return $new_tokens_arr;
                } else {
                    return $this->doAuth($credentials);
                    // return [
                    //     'error' => true,
                    //     'origin' => 'local',
                    //     'response' => $response
                    // ];
                }
            } catch(\Exception $e) {
                return [
                    'error' => true,
                    'origin' => 'local',
                    'response' => $e->getMessage()
                ];
            }
        }
    }    

    public function getSalesOrder()
    {
        $response = null;
        $credentials = $this->getCredentials();
        if(is_array($credentials) && count($credentials) == 6)
        {
            $tokens = $this->getTokens($credentials);
            if(is_array($tokens) && count($tokens) > 0) 
            {
                $defaults = array(
                    CURLOPT_URL => 'https://remote.grwills.com.au:443/WebAPI/API/DB/CustomQuery?key=IWS_SalesOrders',
                    CURLOPT_POST => false,
                    CURLOPT_RETURNTRANSFER => true
                );   

                // $headers = [
                //     'Cache-Control: no-cache',
                //     'Pragma: no-cache',
                //     'Content-Type: application/json; charset=utf-8',
                //     'Expires: -1',
                //     'Referrer-Policy: no-referrer',
                //     'X-Content-Type-Options: nosniff',
                //     'X-Permitted-Cross-Domain-Policies: none',
                //     'X-Xss-Protection: 1; mode=block',
                //     'Strict-Transport-Security: max-age=31536000; includeSubDomains',
                //     "Content-Security-Policy: default-src *; style-src 'self' http://*.sybiz.com 'unsafe-inline' ; script-src 'self' http://* 'unsafe-inline' 'unsafe-eval'; img-src 'self' http://* data:;",
                //     'Permissions-Policy: fullscreen=()',
                //     'Expect-CT: enforce, max-age=30',
                //     'Cross-Origin-Embedder-Policy: require-corp',
                //     'Cross-Origin-Opener-Policy: same-origin',
                //     'Cross-Origin-Resource-Policy: same-origin',
                //     //SERVER: 
                //     //Date: Mon, 26 Jul 2021 04:30:10 GMT
                //     //Content-Length: 31                    
                // ];

                $headers = array(
                    'Cache-Control: no-cache',
                    'Pragma: no-cache',
                    'Expires: -1',
                    "Accept: application/json",
                    'Content-Type: application/json; charset=utf-8',
                    "Authorization: Bearer " . $tokens['access_token'],
                 );

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt_array($ch, $defaults);
                $response = curl_exec($ch);
                curl_close($ch);

                if($response === false) {
                    return [
                        'error' => true,
                        'origin' => 'local',
                        'response' => url_error($ch)
                    ];
                } else {
                    return $this->doProcessItems($response);
                }
            }
        }
        return $response;
    }
    
    private function doProcessItems($response)
    {
        $response = str_replace("\r", "", $response);
        $response = str_replace("\n", "", $response);
        $response = trim($response);
        if(!empty($response)) {
            $parsed = json_decode(trim($response), true);
            if(is_array($parsed) && count($parsed) > 0 && isset($parsed[0]['LineId'])) {
                // -------------------------------------
                if($this->show_logs) $new_response = [];
                // -------------------------------------
                foreach($parsed as $v)
                {
                    try {
                        $picker = !empty($v['Picker']) ? $v['Picker'] : 'Schedule';

                        $stmt = $this->db->prepare("SELECT * FROM sales_order WHERE LineId=?");
                        $stmt->bind_param('d', $v['LineId']);      
                        $stmt->execute();   
                        $result = $stmt->get_result();
                        $so = $result->fetch_assoc();
                        if(empty($so)) {
                            $stmt = $this->db->prepare("INSERT INTO sales_order (
                                LineId, 
                                SortCodeDescription, 
                                SO, 
                                Customer, 
                                Reference, 
                                ProcessedDate, 
                                CreatedOn, 
                                Shipday, 
                                createdby, 
                                value, 
                                Picker, 
                                Code, 
                                Description, 
                                OrdQty
                            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                            $stmt->bind_param('dssssssssdsssd', 
                                $v['LineId'],
                                $v['SortCodeDescription'],
                                $v['SO'],
                                $v['Customer'],
                                $v['Reference'],
                                $v['ProcessedDate'],
                                $v['CreatedOn'],
                                $v['Shipday'],
                                $v['createdby'],
                                $v['value'],
                                $picker,
                                $v['Code'],
                                $v['Description'],
                                $v['OrdQty']
                            );    
                            $save = $stmt->execute();
                            // -------------------------------------
                            if($this->show_logs) {
                                if($save) {
                                    $v['info'] = 'Insert OK';
                                } else {
                                    $v['info'] = 'Insert failed';
                                }
                            }
                            // -------------------------------------
                        } else {
                            if($v['CreatedOn'] == $v['ProcessedDate']) { // no changes
                                // -------------------------------------
                                if($this->show_logs) $v['info'] = 'Skipped';
                                // -------------------------------------
                            } else {
                                if($so['ProcessedDate'] != $v['ProcessedDate']) // changed
                                {
                                    if($this->show_logs) $v['info'] = 'Need update: ' . $so['ProcessedDate'] . ' vs ' . $v['ProcessedDate'];
                                    $stmt = $this->db->prepare("UPDATE sales_order SET
                                        SortCodeDescription=?, 
                                        SO=?, 
                                        Customer=?, 
                                        Reference=?, 
                                        ProcessedDate=?, 
                                        CreatedOn=?, 
                                        Shipday=?, 
                                        createdby=?, 
                                        value=?, 
                                        Picker=?, 
                                        Code=?, 
                                        Description=?, 
                                        OrdQty=?
                                    WHERE LineId=?");
                                    $stmt->bind_param('ssssssssdsssdd', 
                                        $v['SortCodeDescription'],
                                        $v['SO'],
                                        $v['Customer'],
                                        $v['Reference'],
                                        $v['ProcessedDate'],
                                        $v['CreatedOn'],
                                        $v['Shipday'],
                                        $v['createdby'],
                                        $v['value'],
                                        $picker,
                                        $v['Code'],
                                        $v['Description'],
                                        $v['OrdQty'],
                                        $v['LineId']
                                    );    
                                    $update = $stmt->execute();
                                    // -------------------------------------
                                    if($this->show_logs) {
                                        if($update) {
                                            $v['info'] = 'Update OK';
                                        } else {
                                            $v['info'] = 'Update failed';
                                        }
                                    }
                                    // -------------------------------------
                                } else { // no changes
                                    // -------------------------------------
                                    if($this->show_logs) $v['info'] = 'Skipped';
                                    // -------------------------------------
                                }
                            }
                        }     
                        // -------------------------------------
                        if($this->show_logs) $new_response[] = ['SO' => $v['SO'], 'LineId' => $v['LineId'], 'Info' => $v['info']];
                        //if($this->show_logs) $new_response[] = $v;
                        // -------------------------------------
                    } catch(\Exception $e) {
                        if($this->show_logs) $new_response[] = ['SO' => $v['SO'], 'LineId' => $v['LineId'], 'Info' => $e->getMessage()];
                        //if($this->show_logs) $new_response[] = $v;
                    }
                }
                // -------------------------------------
                if($this->show_logs) {
                    return json_encode($new_response);
                } else {
                    return null;
                }
                // -------------------------------------
            }
        }
        // -------------------------------------
        if($this->show_logs) {
            return $response;
        } else {
            return null;
        }
        // -------------------------------------
    }
}
?>