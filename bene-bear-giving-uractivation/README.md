# A WordPress plugin that works with Woocommerce
This plugin is for user registration using a unique code. Customer will be given code during purchase in hand and after that he/she will come to website and register/login
then from the my-account page, 'activation menu, will register the item he/she bought. After successfull registration customer will be able to download a certificate 
on the fly. 

## What are the method/functions used: 
- For the db query - wpdb
- Ajax for the client end
- Sweetalert2 for the frontend message 
- 2 new tables nad relation with posts and postmeta table
- wp-insert-post for creating new cpt with all the code
- update when customer register using ajax
