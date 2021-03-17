<?php
// PS 2

// use the utility scripts
include 'utilScripts.php';

// read username and password that were sent by the JS
$username = $_POST['username'];
$password = $_POST['password'];
$msgAmount = $_POST['msgAmount'];

// read user and message files
$userFileStr = file_get_contents(userFileName);
$messageFileStr = file_get_contents(messageFileName);

// if reading ok:
if (strlen($userFileStr) > 0 && strlen($messageFileStr) > 0) {
    // decode user file
    $userList = json_decode($userFileStr);
    $msgList = json_decode($messageFileStr);
    // if decoding ok:
    if ($userList !== null && $msgList !== null) {
        // check if the password is correct
        $passwordCheckResult = checkPassword($username, $password, $userList);
        
        if ($passwordCheckResult === 'success') {
            $cutMsgList = $msgList;
            // if the message list is too long, trim it
            if (count($cutMsgList) > $msgAmount) {
                $lengthToChop = count($msgList) - $msgAmount;
                $cutMsgList = array_slice($msgList, $lengthToChop);
            }
            echo json_encode($cutMsgList);
        }
        else {
            echo 'WARNINGincorrectPwInChat';
        }
    }
    else {
        echo 'ERRORfileDecodeError';
    }
}
else {
    echo 'ERRORfileReadError';
}
?>