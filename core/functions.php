<?php
    class zoomAPI {
        private $clientId, $clientSecret, $redirectUri;

        public function __construct($clientId, $clientSecret, $redirectUri) {
            $this->clientId = $clientId;
            $this->clientSecret = $clientSecret;
            $this->redirectUri = $redirectUri;
        }
        public function get_accessToken($code) {
            $tokenUrl = 'https://zoom.us/oauth/token';
            $postData = array(
                'grant_type' => 'authorization_code',
                'code' => $code,
                'redirect_uri' => $this->redirectUri
            );
            $clientId = $this->clientId;
            $clientSecret = $this->clientSecret;
            $authorization = base64_encode("{$clientId}:{$clientSecret}");
            $headers = array(
                'Authorization: Basic ' . $authorization,
                'Content-Type: application/x-www-form-urlencoded'
            );
            $data = $this->request_data($tokenUrl, http_build_query($postData), $headers);
            return $data;
        }
        public function create_meeting($data = []) {
            if (!empty($data)) {
                $accessToken = isset($data['accessToken']) ? $data['accessToken'] : "";
                $topicName = isset($data['topicName']) ? $data['topicName'] : "test";
                $type = isset($data['type']) ? $data['type'] : 2;
                $startTime = isset($data['startTime']) ? $data['startTime'] : '2024-07-08T13:20:00Z';
                $duration = isset($data['duration']) ? $data['duration'] : 60;
                $timezone = isset($data['timezone']) ? $data['timezone'] : 'Asia/Tehran';
                $setting = isset($data['setting']) ? $data['setting'] : array(
                    'host_video' => true,
                    'participant_video' => true,
                    'join_before_host' => true,
                    'waiting_room' => false,
                );
            }

            $meetingUrl = 'https://api.zoom.us/v2/users/me/meetings';
            $meetingData = array(
                'topic' => $topicName,
                'type' => $type, // جلسه Scheduled
                'start_time' => $startTime, // زمان شروع به فرمت ISO 8601
                'duration' => $duration, // مدت زمان میتینگ به دقیقه
                'timezone' => $timezone, // منطقه زمانی
                'settings' => $setting
            );
            $meetingHeaders = array(
                'Authorization: Bearer ' . $accessToken,
                'Content-Type: application/json'
            );
            $data = $this->request_data($meetingUrl, json_encode($meetingData), $meetingHeaders);
            return $data;
        }
        public function update_meeting($meetingId, $data = []) {
            $accessToken = isset($data['accessToken']) ? $data['accessToken'] : "";
            unset($data['accessToken']);
            $update = [];
            if(isset($data['topic'])){
                $update['topic'] = $data['topic'];
            }
            if(isset($data['type'])){
                $update['type'] = $data['type'];
            }
            if(isset($data['start_time'])){
                $update['start_time'] = $data['start_time'];
            }
            if(isset($data['duration'])){
                $update['duration'] = $data['duration'];
            }
            if(isset($data['timezone'])){
                $update['timezone'] = $data['timezone'];
            }
            if(isset($data['settings'])){
                $update['settings'] = $data['settings'];
            }
            $meetingUrl = "https://api.zoom.us/v2/meetings/$meetingId";
            $meetingHeaders = array(
                'Authorization: Bearer ' . $accessToken,
                'Content-Type: application/json'
            );
            $data = $this->request_data($meetingUrl, json_encode($update), $meetingHeaders, 'PATCH');
            return $data;
        }
        public function delete_meeting($meetingId, $accessToken) {
            $meetingUrl = "https://api.zoom.us/v2/meetings/$meetingId";
            $meetingHeaders = array(
                'Authorization: Bearer ' . $accessToken,
                'Content-Type: application/json'
            );
            $data = $this->request_data($meetingUrl, [], $meetingHeaders, 'DELETE');
            return $data;
        }

        private function request_data($url, $postData = [], $headers = [], $method = 'POST') {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

            if ($method == 'POST') {
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
            } elseif ($method == 'PATCH') {
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
                curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
            } elseif ($method == 'DELETE') {
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
            } else {
                curl_setopt($ch, CURLOPT_HTTPGET, true);
            }

            if (!empty($headers)) {
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            }

            $response = curl_exec($ch);
            curl_close($ch);
            return $response;
        }
        public function getAuthorization() {
            $clientId = $this->clientId;
            $redirectUri = $this->redirectUri;
            $authUrl = "https://zoom.us/oauth/authorize?response_type=code&client_id=$clientId&redirect_uri=" . urlencode($redirectUri);
            return $authUrl;
        }
        public static function get_duration($start_time,$end_time){
            $startDateTime = new DateTime($start_time);
            $endDateTime = new DateTime($end_time);
            $interval = $startDateTime->diff($endDateTime);
            $duration = ($interval->days * 24 * 60) + ($interval->h * 60) + $interval->i;
            return $duration;
        }
        public static function create_starttime($start_date,$start_time){
            $datetime_string = $start_date . ' ' . $start_time;
            $date = $start_date."T".$start_time."Z";
            return $date;
        }
    }
?>