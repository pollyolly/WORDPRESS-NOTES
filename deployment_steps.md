1. Update the apache config for the wordpress folder.

2. Disable the caching plugin and re-enable after the deployment process.

3. Double check the plugins if still supported. Deactivate by changing the folder name of the plugin. i.e deactivate_pluginname

4. Migrate the Upload files inside the wp-content.

5. Check the page content if updated and no fixes needed.

6. Update static url. Note you may use trailing slash "/" so that the baseURL is automatically added.
```
  i.e 
      /About
      /ContactUs
```
7. Update the base url in the database using SQL query or a plugin i.e Search and Replace.
