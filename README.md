# task_manager
# setup dabase and server
import database using sql file named task_manager.sql
running apache

# description
This application using for entry task, update status of task, and delete task. 
This application has validation on all field for create data. 
There are two search filter like search by title and search by status on it. This application was implemented parameterized query to prevent SQL injection.

# how to test
search 
1. click search button
2. fill title search field then click search button
3. select status search option then click search button
4. fill title search field and select status search option then click search button

create
1. fill all form of create task then click save button 
2. fill title field then click save button (validation test)
3. fill description field then click save button (validation test)

update
1. click dropdown on action then select one of status option

delete
1. click delete on one of task data row

