## About GuestbookKLN

GuestbookKLN is a web application developed using laravel.

##Laravel features used
- ** Auth
- ** Form Request
- ** Validation
- ** Migration
- ** Guzzle

##Feature 

- ** Admin Panel
	- Login Page
	- Admin page (to edit password)
	    - Users menu -> users -> update password
	- Logout
	    - Header / Top Menu, beside the home menu
	- Guestbook
	    - List table Guestbook
	    - Add Guest Book
	    - Edit Guest Book
	    - Delete Guest Book (record on database must still exist after deleted, use special fields to flag the deleted or active guestbook)
	- Grab Province and City from External API to database
		- Menu location Admin Panel -> Location -> Province / City -> List -> Click Button Import
		- In this process, a check is made on the code and name, if it is registered it is not imported
		
- ** Front Page


	- Show Admin form with input:
		Old password
		New password
		Confirm password
		If no new password enter, the password are not changed.

	- Show Guestbook form with input:
	   First Name
	   Last Name
	   Organization
	   Address
	   Province
	   City
	   Phone
	   
	   


# guestbookkln
