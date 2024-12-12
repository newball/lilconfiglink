<!DOCTYPE html>
<?php
class lilConfigLoader {
  private $data;

  public function __construct(string $filePath) {
    if (!file_exists($filePath)) {
      throw new Exception( "Configuration file not found: $filePath" );
    }
    $fileData = file_get_contents( $filePath );
    $this->data = json_decode( $fileData, true );

    if ( json_last_error() !== JSON_ERROR_NONE ) {
      throw new Exception( "Error parsing JSON: " . json_last_error_msg() );
    }
  }

  public function get( string $path, $default = null ) {
    $keys = explode( '.', $path );
    $value = $this->data;

    foreach ( $keys as $key ) {
      if ( !isset ( $value[$key] ) ) {
        return $default;
      }
      $value = $value[$key];
    }
    return $value;
  }
}

class Identity {
  private $config;

  public function __construct( lilConfigLoader $config ) {
    $this->config = $config;
  }

  public function getTheme(): string {
    return $this->config->get( 'breanding.theme', 'theme-auto' );
  }

  public function getLanguage(): string {
    return $this->config->get( 'meta.language', 'en' );
  }

  public function getName(): string {
    return $this->config->get( 'identity.name', "Lil' Config Link" );
  }

  public function getBrand(): string {
    return $this->config->get( 'identity.branding', '' );
  }

  public function getAvatarIcon(): string {
    $avatar_type = $this->config->get( "identity.avatar", '' );
    $email = $this->config->get( 'identity.email', '');

    switch ( $avatar_type ) {
      case 'gravatar':
        $avatar_icon = "https://www.gravatar.com/avatar/" . md5(strtolower(trim($email)));
        break;
      case 'libravatar':
        $avatar_icon = "https://seccdn.libravatar.org/avatar/" . md5(strtolower(trim($email)));
        break;
      case 'dicebear':
        $name = $this->config->get( 'identity.name', 'default' );
        $avatar_icon = "https://avatars.dicebear.com/api/identicon/$name.svg";
        break;
      default:
        $avatar_icon = '/images/avatar.png';
        break;
    }

    return $avatar_icon;
  }

  public function getAvatarClass(): string {
    return $this->config->get( 'identity.avatar_class', 'avatar-default' );
  }

  public function getDescription (): string {
    return $this->config->get( 'identity.description', 'Replace this with your own, this appears in search results and when sharing.' );
  }

  public function getTags (): string {
    $tags = $this->config->get( 'identity.tags', [] );
    if ( !empty( $tags ) ) {
      return implode( ', ', $tags );
    }
    return $tags;
  }

  public function getUrl (): string {
    return $this->config->get( 'identity.url', 'https://yourwebsite.com' );
  }

  public function getLinks (): array {
    return $this->config->get( 'links', [] );
  }
}

try {
  // Create a new ConfigLoader instance
  $lil_config_loader = new lilConfigLoader('identity.json');
  $identity = new Identity( $lil_config_loader );

  // Get the data from the configuration file
  $theme = $identity->getTheme();
  $language = $identity->getLanguage();
  $name = $identity->getName();
  $brand = $identity->getBrand();
  $avatar_icon = $identity->getAvatarIcon();
  $description = $identity->getDescription();
  $tags = $identity->getTags();
  $url = $identity->getUrl();
  $links = $identity->getLinks();
  // Markup Variables
  $avatar_class = $identity->getAvatarClass();
  
} catch (Exception $e) {
  die('Error: ' . $e->getMessage());
}
?>

<html class="<?php echo htmlspecialchars( $theme ); ?>" lang="<?php echo htmlspecialchars( $language ); ?>">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
      
  <title><?php echo !empty($brand) ? htmlspecialchars( $brand ) : htmlspecialchars( $name ); ?></title>
  <link rel="icon" type="image/x-icon" href="<?php echo htmlspecialchars( $avatar_icon ) ?>">
  <meta name="description" content="<?php echo htmlspecialchars( $description ); ?>">
  <meta name="keywords" content="<?php echo htmlspecialchars( $tags ); ?>">
  <meta rel="canonical" href="<?php echo htmlspecialchars( $url ); ?>">
  <meta name="author" content="<?php echo htmlspecialchars ( $name ); ?>">
  
  <link rel="stylesheet" href="css/reset.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/brands.css">
</head>

<body>
    <div class="container">
        <div class="column">
            <img class="avatar <?php echo htmlspecialchars( $avatar_class ) ?>" src="<?php echo htmlspecialchars( $avatar_icon ); ?>" srcset="<?php echo htmlspecialchars( $avatar_icon ); ?>" alt="<?php echo !empty($brand) ? htmlspecialchars( $brand ) : htmlspecialchars( $name ); ?>">
            <h1 tabindex="0">
              <div><?php echo !empty($brand) ? htmlspecialchars( $brand ) : htmlspecialchars( $name ); ?></div>
            </h1>

            <p tabindex="0"><?php echo htmlspecialchars( $description ); ?></p>

            <div class="button-stack" role="navigation">
            <?php 
                foreach ( $links as $link ) {
                  $button_title = htmlspecialchars($link['title'] ?? "Default Link");
                  $button_url = htmlspecialchars($link['url'] ?? "#");
                  $button_class = htmlspecialchars($link['class'] ?? "button-default");
                  $button_icon = htmlspecialchars($link['icon'] ?? "default");
                  $button_description = htmlspecialchars($link['description'] ?? "Button Icon");

                  printf('<a class="button %s" href="%s" target="_blank" rel="noopener" role="button"><img class="icon" aria-hidden="true" src="images/icons/%s.svg" alt="%s">%s</a>', $button_class, $button_url, $button_icon, $button_description, $button_title);
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
