#how zoom meeting Libraries working

This README file provides clear instructions on how to use the `zoomAPI` class, covering initialization, authorization, and the main functionalities of creating, updating, and deleting meetings.

# Zoom API PHP Wrapper

This PHP class provides a simple interface to interact with the Zoom API. It allows you to authorize, create, update, and delete Zoom meetings.

## Installation

1. Clone the repository or download the `autoload.php` file.
2. Include the `autoload.php` file in your project.

```php
require_once 'autoload.php';
### Initialization

First, initialize the `zoomAPI` class with your Zoom App credentials.

```php
$zoom = new zoomAPI('your_client_id', 'your_client_secret', 'your_redirect_uri');
- `### Initialization`: This is a sub-subheading for the initialization section.
- The paragraph explains how to initialize the class.
- The code block shows the PHP code for initializing the class.

#### 3.2 Authorization
```markdown
### Authorization

To get the authorization URL, use the `getAuthorization` method and visit the URL to authorize your app.

```php
$authUrl = $zoom->getAuthorization();
echo "Visit the following URL to authorize the application: $authUrl";
- `### Authorization`: This is a sub-subheading for the authorization section.
- The paragraph explains how to get the authorization URL.
- The code block shows how to call the `getAuthorization` method and display the URL.
- The following paragraph explains what to do after authorization.

#### 3.3 Get Access Token
```markdown
### Get Access Token

```php
$accessTokenData = $zoom->get_accessToken('authorization_code_received_from_zoom');
$accessToken = json_decode($accessTokenData)->access_token;
- `### Get Access Token`: This is a sub-subheading for getting the access token.
- The code block shows how to get the access token using the received authorization code.

#### 3.4 Create a Meeting
```markdown
### Create a Meeting

To create a meeting, use the `create_meeting` method.

```php
$meetingData = [
    'accessToken' => $accessToken,
    'topicName' => 'My Meeting',
    'type' => 2,
    'startTime' => '2024-07-08T13:20:00Z',
    'duration' => 60,
    'timezone' => 'Asia/Tehran',
    'setting' => [
        'host_video' => true,
        'participant_video' => true,
        'join_before_host' => true,
        'waiting_room' => false,
    ]
];
$response = $zoom->create_meeting($meetingData);
print_r(json_decode($response, true));
- `### Create a Meeting`: This is a sub-subheading for creating a meeting.
- The paragraph explains how to create a meeting using the `create_meeting` method.
- The code block shows an example of creating a meeting with various parameters.

#### 3.5 Update a Meeting
```markdown
### Update a Meeting

To update a meeting, use the `update_meeting` method.

```php
$updateData = [
    'accessToken' => $accessToken,
    'topic' => 'Updated Meeting Topic',
    'start_time' => '2024-07-08T14:00:00Z',
    'duration' => 45,
    'timezone' => 'Asia/Tehran',
    'settings' => [
        'host_video' => false,
        'participant_video' => true,
        'join_before_host' => false,
        'waiting_room' => true,
    ]
];
$meetingId = 'your_meeting_id';
$response = $zoom->update_meeting($meetingId, $updateData);
print_r(json_decode($response, true));
- `### Update a Meeting`: This is a sub-subheading for updating a meeting.
- The paragraph explains how to update a meeting using the `update_meeting` method.
- The code block shows an example of updating a meeting with various parameters.

#### 3.6 Delete a Meeting
```markdown
### Delete a Meeting

To delete a meeting, use the `delete_meeting` method.

```php
$meetingId = 'your_meeting_id';
$response = $zoom->delete_meeting($meetingId, $accessToken);
print_r(json_decode($response, true));
- `### Delete a Meeting`: This is a sub-subheading for deleting a meeting.
- The paragraph explains how to delete a meeting using the `delete_meeting` method.
- The code block shows an example of deleting a meeting by its ID.

### 4. Helper Functions
```markdown
### Helper Functions
#### Calculate Duration

To calculate the duration between two times:

```php
$duration = zoomAPI::get_duration('2024-07-08T13:20:00Z', '2024-07-08T14:20:00Z');
echo "Duration: $duration minutes";
- `#### Calculate Duration`: This is a sub-sub-subheading for calculating the duration.
- The paragraph explains how to calculate the duration between two times.
- The code block shows an example of using the `get_duration` method.

#### 4.2 Create Start Time
```markdown
#### Create Start Time

To create a start time string from a date and time:

```php
$startTime = zoomAPI::create_starttime('2024-07-08', '13:20:00');
echo "Start Time: $startTime";
- `#### Create Start Time`: This is a sub-sub-subheading for creating a start time.
- The paragraph explains how to create a start time string from a date and time.
- The code block shows an example of using the `create_starttime` method.

### 5. License
```markdown
## License

This project is licensed under the MIT License. See the LICENSE file for details.

