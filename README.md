# zoomAPI Class

## Overview

The `zoomAPI` class provides methods to interact with the Zoom API, including handling OAuth authorization, creating, updating, and deleting Zoom meetings.

## How to Use

1. **Initialize the Class**

    ```php
    $zoom = new zoomAPI($clientId, $clientSecret, $redirectUri);
    ```

2. **Get Access Token**

    ```php
    $accessToken = $zoom->get_accessToken($code);
    ```

3. **Create a Meeting**

    ```php
    $meetingData = array(
        'accessToken' => $accessToken,
        'topicName' => 'Meeting Topic',
        'type' => 2,
        'startTime' => '2024-07-08T13:20:00Z',
        'duration' => 60,
        'timezone' => 'Asia/Tehran',
        'setting' => array(
            'host_video' => true,
            'participant_video' => true,
            'join_before_host' => true,
            'waiting_room' => false
        )
    );
    $response = $zoom->create_meeting($meetingData);
    ```

4. **Update a Meeting**

    ```php
    $updateData = array(
        'accessToken' => $accessToken,
        'topic' => 'Updated Topic',
        'start_time' => '2024-07-08T14:00:00Z',
        'duration' => 90
    );
    $response = $zoom->update_meeting($meetingId, $updateData);
    ```

5. **Delete a Meeting**

    ```php
    $response = $zoom->delete_meeting($meetingId, $accessToken);
    ```

6. **Get Authorization URL**

    ```php
    $authUrl = $zoom->getAuthorization();
    ```

7. **Calculate Meeting Duration**

    ```php
    $duration = zoomAPI::get_duration($start_time, $end_time);
    ```

8. **Create Start Time String**

    ```php
    $startTime = zoomAPI::create_starttime($start_date, $start_time);
    ```
