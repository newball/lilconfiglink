<!DOCTYPE html>
<?php
  try {
    // Read the contents of the file
    $jsonContent = file_get_contents( 'identity.json' );

    // Decode the JSON content
    $data = json_decode($jsonContent, true); // 'true' converts JSON to an associative array

    // Check if decoding was successful
    if (json_last_error() === JSON_ERROR_NONE) {
    } else {
      // Handle JSON decoding errors
      throw new Exception("JSON decoding error: " . json_last_error_msg());
    }
  } catch (Exception $e) {
    // Catch and handle any file reading or parsing errors
    echo "Error reading or parsing JSON: " . $e->getMessage();
    die();
  }

  $theme = !empty($data['branding']['theme']) ? $data['branding']['theme'] : 'theme-auto';
  $language = !empty($data['meta']['language']) ? $data['meta']['language'] : 'en';
  
  $name = !empty($data['identity']['name']) ? $data['identity']['name'] : "Lil' Config Link";
  $brand = !empty($data['identity']['branding']) ? $data['identity']['branding'] : "";
  
  $avatar = !empty($data["identity"]["avatar"]) ? $data["identity"]["avatar"] : "/images/avatar.png";
  $avatar_class = !empty($data["identity"]["avatar_class"]) ? $data["identity"]["avatar_class"] : "avatar-default";

  switch ($avatar) {
    case 'gravatar':
      $avatar_icon = "https://www.gravatar.com/avatar/" . md5(strtolower(trim($data['identity']['email'])));
      break;
    case 'dicebear':
      $avatar_icon = "https://avatars.dicebear.com/api/identicon/" . $data['identity']['name'] . ".svg";
      break;
    default:
      $avatar_icon = $avatar;
      break;
  }

$description = !empty($data["identity"]["description"]) ? $data["identity"]["description"] : "Replace this with your own, this appears in search results and when sharing.";
$tags = !empty($data["identity"]["tags"]) ? implode(", ", $data["identity"]["tags"]) : "your name, industry, and specialties";
$url = !empty($data["identity"]["url"]) ? $data["identity"]["url"] : "https://yourwebsite.com";
$links = !empty($data["links"]) ? $data["links"] : array();

?>

<html class="<?php echo $theme; ?>" lang="<?php echo $language; ?>">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
      
  <title><?php echo !empty($brand) ? $brand : $name; ?></title>
  <link rel="icon" type="image/x-icon" href="<?php echo $avatar_icon?>">
  
  <meta name="description" content="<?php echo $description; ?>">
  
  <meta name="keywords" content="<?php echo $tags; ?>">
  
  <meta rel="canonical" href="<?php echo $url; ?>">
  
  <meta name="author" content="<?php $name; ?>">
  
  <link rel="stylesheet" href="css/reset.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/brands.css">
</head>

<body>

    <div class="container">
        <div class="column">

            <img class="avatar <?php ?>" src="<?php echo $avatar_icon; ?>" srcset="<?php echo $avatar_icon; ?>" alt="LittleLink">

            <h1 tabindex="0">
              <div><?php echo !empty($brand) ? $brand : $name; ?></div>
            </h1>

            <!-- Add a short description about yourself or your brand -->
            <p tabindex="0"><?php echo $description; ?></p>

            <!-- All your buttons go here -->
            <div class="button-stack" role="navigation">

              <?php 
                if ( !empty($links) ) {
                  foreach ($links as $button) {
                    $button_title = !empty($button['title']) ? $button['title'] : "Default Link";
                    $button_url = !empty($button["url"]) ? $button["url"] :"#";
                    $button_class = !empty( $button["class"] ) ? $button["class"] :"button-default";
                    $button_icon = !empty($button["icon"]) ? $button["icon"] :"littlelink";
                    $button_description = !empty($button["description"]) ? $button["description"] :"Button Logo";

                    printf('<a class="button %s" href="%s" target="_blank" rel="noopener" role="button"><img class="icon" aria-hidden="true" src="images/icons/%s.svg" alt="%s">%s</a>', $button_class, $button_url, $button_icon, $button_description, $button_title);
                  }
                }
              ?>
      </div>
        
      <!-- Feel free to add your own footer information, including updating `privacy.html` to reflect how your LilConfigLink fork is set up -->
      <footer>
        <a href="privacy.html">Privacy Policy</a> | Build your own by forking <a href="https://github.com/newball/lilconfiglink" target="_blank" rel="noopener">LilConfigLink</a>
      </footer>
    
    </div>
  </div>

</body>

</html>
