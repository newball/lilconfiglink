# LilConfigLink

A DIY, self-hosted LinkTree alternative, forked from [LittleLink](https://github.com/sethcottle/littlelink). The idea is simple... create a LinkTree like page using a file, that produces a single page of links.

---

## LittleLink Compatability

Currently, LilConfigLink is compeltely comptable with LittleLink, using all of the same classes, files, and structure. This may change in the future.

---

## Deploy and How It Works

Keeping the mantra of "it works as-is", to make LilConfigLink work, you need the following requirements:

- a server that runs PHP

There's no need for any databases, gulp, grunt, npm, rails, ruby, nada.

PHP reads the `identity.json` file and then produces all of the information.

---

## JSON File Configuration

1. [Identity Section](#identity-section)
2. [Links Section](#links-section)
3. [Branding Section](#branding-section)
4. [Meta Section](#meta-section)
5. [Version Information](#version-information)

### Identity Section

The `identity` section defines the primary details of the user or entity. Replace placeholder values with your actual data.

#### Identity Fields

- **`name`**: Your name or your brand's name.
- **`branding`**: Your organization's brand name.
- **`email`**: Your contact email.
- **`url`**: Your website's URL.
- **`description`**: A short description for SEO and sharing purposes.
- **`tags`**: Keywords to describe the identity (e.g., specialties or industries).
- **`avatar`**: Source for your avatar (e.g., `gravatar`).
- **`avatar_class`**: CSS class for styling the avatar (e.g., `avatar--rounded`).

#### Identity Example

```json
"identity": {
    "name": "Jane Doe",
    "branding": "Jane's Designs",
    "email": "jane.doe@example.com",
    "url": "https://janesdesigns.com",
    "description": "Freelance designer specializing in modern and responsive design.",
    "tags": ["design", "web development", "UI/UX"],
    "avatar": "gravatar",
    "avatar_class": "avatar--rounded"
}
```

### Links Section

The `links` section provides a list of social profiles, resources, or relevant links.

#### Links Fields

- **`title`**: The display name of the link.
- **`url`**: The target URL for the link.
- **`class`**: CSS class for button styling.
- **`icon`**: Icon class name for displaying a logo or image.
- **`description`**: Tooltip or alt text for accessibility.

#### Links Example

```json
{
    "title": "LinkedIn",
    "url": "https://linkedin.com/in/janedoe",
    "class": "button-linkedin",
    "icon": "linkedin",
    "description": "LinkedIn Logo"
}
```

#### Adding a New Link

1. Copy an existing link object or add your own.
2. Replace the placeholder values (`title`, `url`, `class`, `icon`, `description`) with your own data.
3. Save the changes in the JSON file.

### Branding Section

The `branding` section allows you to customize the theme of the application.

#### Branding Fields

- **`theme`**: Defines the theme for your project. Default is `theme-auto`, which automatically adjusts based on user preferences. Currently supports `theme-auto`, `theme-light`, and `theme-dark`. This can be replaced with your own theme name

#### Branding Example

```json
"branding": {
    "theme": "theme-light"
}
```

### Meta Section

The `meta` section contains technical information about the configuration.

#### Meta Fields

- **`rel`**: Specifies the relationship type (default: `self`).
- **`href`**: Base URL for the configuration (useful for APIs).
- **`version`**: Current version of the JSON configuration.
- **`language`**: Language code (e.g., `en` for English).

#### Meta Example

```json
"meta": {
    "rel": "self",
    "href": "http://localhost:8080/identity",
    "version": "1.0.0",
    "language": "en"
}
```

---

## Version Information

This configuration file adheres to **version 1.0.0**. Future versions may include additional fields or updates. Please check the changelog for any compatibility notes when upgrading.

---

## Acknowlegements

- [LittleLink](https://github.com/sethcottle/littlelink) is great. Go support the project.

---

## Why the name LilConfigLink

**The technical reason**: I wanted to create something that was small, using a config file to create a "Link-in-bio" like page, that can potentially fuel other services and ideas.

**Actual reason**: When working on the proof-of-concept I was listening to Lil' Jon when and simply said "JYEAH!"

No seriously, that's what happened.

---

## Disclaimer

The progjest is a direct fork of LittleLink, and has a lot of references to it at the moment. These will be removed / ironed out shortly, but right now, I wanted to get the proof of concept completed before doing a lot of internal stuff.
