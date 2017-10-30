## What is this repo for?
This is Ziyang Wang and Miao Gao's Module 5 group work.  
This is the [site](http://majorkevin.me/CSE503M5-G/)

## What do we do for Basic
We implement all the basic requirements, including register, login, add, edit, delete event for users.  
Double click on space of the date grid, and users can add event in the popover.  
Click on the event shown in the date grid, users can edit, delete or share their events.

## account table
|username| password|
|--------|---------|
|kevin   | 12345   |
|miao    | 54321   |
|kirk    | 12345   |

## Creative Portion
For creative portion, we take two ideas provided by the wiki and implement them, which are group event and share event with others.
Users can choose create group event when add an event and still can share events to other users aftering creating them.
Users can also create common event and share with others.
For the most exciting portion is we implement the place for events. We use the google map api to provide places and its geometry information. Then we bind the geometry information with users' events and show them in the calendars. In this case, the following files are **not** written by us:
>googleapi.js  
>temp.html  
>specLocation.html

These three files are samples provided by google map javascript api and we simply use them for our calendar. These will not count into our creative portion.
When creating an event, users can choose a place by typing it in the search box and auto-completed by google api. After choosing the place and adding the event, the location would be shown in the map when users view the events they added.