<?php
function urlRequest($correntUrl){
    $actual_link = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    if($actual_link == $correntUrl){
        return true;
    }else{
        return false;
    }
}
function getBaseUrl($url) {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $host = $_SERVER['HTTP_HOST'];
    $baseUrl = $protocol . $host;
    return $baseUrl . '/'. $url;
}
function getfileName($img){
    $img_ext = pathinfo($img, PATHINFO_EXTENSION);
    $filename = time() . '.' . $img_ext;
    return $filename;
}
function move_file($img,$filename,$path = "storage/upload/")
{
    if( move_uploaded_file($img["tmp_name"],$path.'/'.$filename)){
        return true;
    }
    else{
        return false;
    }
}
function delete_file($imgName,$path = "storage/upload/")
{
    if(file_exists($path.$imgName))
    {
        if(unlink($path.$imgName)){
            return true;
        }else{
            return false;
        }
    }
}
function location_back(){
    return  header('location:'. $_SERVER['HTTP_REFERER']);
}

// ================this is funtion for make data input to best============== 
function testInput($data)
{
    $data = trim($data);
    $data = stripcslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
// ========================this is for Validate data email or photo================
function validateInput($input) {
    if (filter_var($input, FILTER_VALIDATE_EMAIL)) {
        return "Email";
    }
    
    if (preg_match('/^[0-9]{10,15}$/', $input)) {
        return "Phone";
    }
    return false;
}
// ======================this is for covert to khmer date ===================
function convertDate($time, $change, $short = false) {
    // Set the default timezone to the server's local timezone
    date_default_timezone_set('Asia/Phnom_Penh');

    // Create a DateTime object from the provided time and timezone
    $dateTime = new DateTime($time, new DateTimeZone('UTC'));

    // Set the target timezone to the local timezone
    $dateTime->setTimezone(new DateTimeZone('Asia/Phnom_Penh'));

    // Get the components of the date and time
    $dayOfWeek = $dateTime->format('D');
    $day = $dateTime->format('d');
    $month = $dateTime->format('M');
    $year = $dateTime->format('Y');
    // $timeFormatted = $dateTime->format('H:i:s A');

    // Khmer translations for days of the week and months
    $daysOfWeekKh = [
        'Mon' => 'ចន្ទ',
        'Tue' => 'អង្គា',
        'Wed' => 'ពុធ',
        'Thu' => 'ព្រហ',
        'Fri' => 'សុក្រ',
        'Sat' => 'សៅរ៍',
        'Sun' => 'អាទិ'
    ];

    $monthsKh = [
        'Jan' => 'មករា',
        'Feb' => 'កុម្ភៈ',
        'Mar' => 'មីនា',
        'Apr' => 'មេសា',
        'May' => 'ឧសភា',
        'Jun' => 'មិថុនា',
        'Jul' => 'កក្កដា',
        'Aug' => 'សីហា',
        'Sep' => 'កញ្ញា',
        'Oct' => 'តុលា',
        'Nov' => 'វិច្ឆិកា',
        'Dec' => 'ធ្នូ'
    ];

    // Convert English numbers to Khmer numbers
    $khmerNumbers = ['០', '១', '២', '៣', '៤', '៥', '៦', '៧', '៨', '៩'];
    $englishNumbers = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

    if ($change == 'kh') {
        // Replace English numbers with Khmer numbers
        // $day = str_replace($englishNumbers, $khmerNumbers, $day);
        // $year = str_replace($englishNumbers, $khmerNumbers, $year);
        // $timeFormatted = str_replace($englishNumbers, $khmerNumbers, $timeFormatted);
        // $timeFormatted = str_replace(':', ' ', $timeFormatted);

        // $timeFormatted = str_replace(['AM', 'PM'], ['ព្រឹក', 'ល្ងាច'], $timeFormatted);
        $Date = "{$daysOfWeekKh[$dayOfWeek]} ទី{$day} ខែ{$monthsKh[$month]} ឆ្នាំ{$year}";
    } else {
        if($short == true){
            $Date = "{$day} {$month} {$year}";
        }else{
            $Date = "{$dayOfWeek} {$day} {$month} {$year}";
        }
    }

    return $Date;
}
function sanitizeContent($content) {
    // Allow only safe HTML tags
    $allowed_tags = '<p><a><div><span><h1><h2><h3><h4><h5><h6><ul><li><ol><strong><em><i><b><br><hr><table><tr><td><th><thead><tbody><tfoot><img><figure><figcaption><blockquote><code><pre>';
    $sanitized_content = strip_tags($content, $allowed_tags);

    // Remove any potentially harmful attributes
    $sanitized_content = preg_replace('/(<[^>]+?)\s+on[a-z]+\s*=\s*["\'][^"\']*["\']/i', '$1', $sanitized_content);

    // Remove any inline JavaScript code
    $sanitized_content = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', '', $sanitized_content);

    // Remove any JavaScript or data URLs in href/src attributes
    $sanitized_content = preg_replace('/(href|src)\s*=\s*["\']javascript:[^"\']*["\']/i', '', $sanitized_content);

    return $sanitized_content;
}

function getCurrentUrl(){
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $domainName = $_SERVER['HTTP_HOST'];
    $requestUri = $_SERVER['REQUEST_URI'];
    $currentUrl = $protocol . $domainName . $requestUri;
    return $currentUrl;
}

