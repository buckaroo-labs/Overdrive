# Compass
An application for viewing and navigating IT infrastructure data

This application was developed for a production support team responsible for hundreds of services running on hundreds of hosts for several applications, each with several environments. It became impractical to maintain the server inventory as PuTTY connections in each team member's Windows registry and/or as entries in each Oracle TNSNAMES file. So I created a database to store the information and UI for viewing it, including links in the browser which could launch a PuTTY or sqlplus session. 

The application has been redesigned on the Hydrogen framework (see my repository of the same name) and migrated to a MySQL back end from the original Oracle design.



