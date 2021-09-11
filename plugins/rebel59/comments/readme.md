# Rebel59 Comments

## Features
- Post Comments on any page
- Post comments reload-free.
- Uses October's AJAX framework to refresh update comment partials.
- Attach Comments to any model
- Comment both as guest and user
- Disable comments (+ soft disable for guest users)
- Reply Notifications (+ unsubscribe)
- Edit your comments as registered user
- Delete comments as registered user
- Backend Admin interface for deleting and editing comments

### Planned features
- Cycling through comments with AJAX
- Avatars (Randomized for guest users, gravater for logged in)
- Front-end admin functionality
- Rating System

## Usage
There are two ways to use the comments component. It can be attached to an external model, and it can be linked to a page through the `baseFileName`. 
When attaching comments to another model, the plugin extends the given model in its `boot` method. 
All models that are defined in the settings menu will be automatically extended.

### Comments as a relation / URLs with slugs

**Settings fields**

    plugin:
        label: Plugin Name
        placeholder: Rebel59.Comments
    model:
        label: Model Name
        placeholder: Rebel59\Comments\Models\Comment;
      
When attaching comments to URLs with slugs, this functionality is encouraged. This also makes sure that the comments stay attached to a model should the base URL change. 

Before models can be linked they need to be defined in the settings menu. When this is done, they can be selected from the `externalRelation` property. 
Attaching comments to models gives the advantage that the comments can also be accessed through `modelname.comments` to load the
comments through a relation instead of the comment model itself.

**Example: accessing comments from a model (Foo)**

    {% for comment foo.comments %}
      {{ comment }}
    {% endfor %}
    
    
### Comments as a component

Drag and drop the `comments` component onto a page, just like you would with any OctoberCMS plugin. Fill in the required properties
and you are good to go.

## Components

### Comments

The `comments` component generates the comment list pased on its properties. Comments are loaded based on either the model reference, or page URL (in that order).

#### Properties
##### `loadCss (Boolean | default: true)`
Loads predefined CSS that comes bundled with the plugin.

##### `loadJs (Boolean | default: true)`
Loads predefined CSS that comes bundled with the plugin.

##### `disableComments (Booleam | default: false)`
Disables all comments for the page.

##### `disableGuestComments (Boolean | default: true)`
Disable comments for all guest users.

##### `registerPage (CMS Page)`
The register new user page.

##### `listElement (HTML Selector)`
The HTML element that contains the comment list.

##### `location (Dropdown | default: append)`
Determines whether new comments are placed at the top of the comment list, or at the bottom.

##### `commentsPerPage (Number | default: 20)`
The amount of comments that are displayed on the first page.

##### `pageNumber (Parameter | default: page)`
The parameter for the page number.

##### `unsubscribePage (CMS Page)`
The page that is used for unsubscribing from the email notifications.

##### `externalRelation (Dropdown)`
A list of external models registered in the application. This list can be edited in the settings menu of the CMS. This data is used to attach the comments to the given model.

##### `externalRelationParam (Parameter)`
The URL parameter that is used as the key to attach the comment to the model.
   
### Unsubscribe

The `unsubscribe` component enables users to unsubscribe from email notifications. It references the token, decrypts it and matches it with a comment ID. 

#### Properties

##### `token (Parameter | encrypted)`
The URL parameter that contains the ID of the comment. The ID is encrypted using the application's key and the opt-out link is sent along with every notification.

## Adding Translations
If you want to see the plugin translated in your own language, please feel free to attach the language file in the support forum. We'll make sure it will get added ASAP.

## Bugs, Feature Requests and Pull Requests
Feature Requests and Bug reports can be handled through the support forums. Please label Feature Requests with `[Feature Request]` in the title.

If you want access to the Private Github Repo let us know by sending an email explaining why to `info@rebel59.nl`.
