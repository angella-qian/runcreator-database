# RunCreator Database Website

**Live website viewable here:**

**Purpose:** 
- My website features full CRUD functionality while providing access to the custom routes entered onto the RunCreator database. 
- The website was inspired by an iOS app I'm designing in another course. 
- Users are able to add their own routes, or just read and add reviews to existing ones. Meanwhile, admins can create, update, and delete any reviews that they wish to.

**Admin Permissions Credentials:**
- Username:    admin
- Password:     admin

**General User Permissions Credentials (or you can create your own account):**
- Username:    student
- Password:     student

**Password-Protected Pages:**
- Delete.php, Add_Route.php, Add_Review.php, Edit_Form.php, and MyReviews.php are password-protected pages to ensure that users are logged in before they can access and edit data.

**Source of Data:**
- Data about the custom routes and their respective reviews have been stored in the database. 
- This includes standard information about runs such as skill level, route name, distance, elevation gain, surface type, and city. 
- I used various sources for my data, including: Map My Run, Google Maps, and Run Keeper. 
- On top of that, to implement user permissions and reviews on the website, I had to store information about users, access levels, and reviews.

**Extras Used:**
- *Frontend ↔ Backend AJAX ( JavaScript ↔ PHP )*
  - Used on the Search Routes data table
  - Allows user to search via filters and receive results right away
- *Different User Permission Levels*
  - General User
    - Can create, read, update, and delete on their own reviews only
    - Can create and read routes
  - Admin
    - Can create, read, update, and delete on both their own and others' reviews
    - Can create and read routes
- *Pagination*
  - Used on the Search Routes data table to help with legibility
  - Used on the My Reviews data table to help with legibility
