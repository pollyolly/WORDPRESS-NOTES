1. Update the apache config for the wordpress folder.

2. Double check the plugins if still supported.

3. Migrate the Upload files inside the wp-content.

4. Check the page content if updated and no fixes needed.

5. Update static url. Note you may use trailing slash "/" so that the baseURL is automatically added.
```
  i.e 
      /About
      /ContactUs
```
6. Update the base url in the database using SQL query or a plugin i.e Search and Replace.
