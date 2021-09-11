#Short description

Keep your files in order by using our **Intranet plugin**. With this plugin you can create infinite number of categories and subcategories and order them as you wish. Easily upload files with drag&drop up to 10 files simultaneously with ease. Once you have categories and files set you can easily search and preview or download them, share files directly on email, move files from category to category, rename category or delete it.

By default you will have two categories already in place, **“Uncategorised”** and **“Secure”**. 
In case you want to delete category or you delete it by mistake, all subcategories will be deleted but every file will be moved to **“Uncategorised”**, so if you want to delete file you delete them directly with provided option.

##Security
Intranet has 2 levels of permission you can set on your user roles. 
1. Intranet access
-  If user has permission then Intranet menu item will be shown inside administration panel
2. Secure category access
- If user has permission then **“Secure”** category will be shown in category menu and user will be able to read or upload files inside that category

##Libraries used by Intranet
1. Vue.js - MIT https://vuejs.org/
2. Dropzone.js - MIT https://www.dropzonejs.com/
3. JQuery datatables - MIT https://datatables.net/
4. SweetAlert2.js - MIT https://sweetalert2.github.io/

###Understanding plugin logic
Please check contracts folder there you will find interfaces implemented by model and repository. From there you can get general idea how everything works and in case you want to extend the plugin functionality use interfaces and it's methods to speed up your development and code readability.

###Email layout and template
Plugin will register Intranet layout and it's template. Styling of layout can be changed as every other email layout or template inside OctoberCMS administration.

###Storage
Since category folders and files are stored inside storage you have to set up storage folder permissions.

###Filepaths
Inside config folder you can find base filepath and file model has methods to return filepath.