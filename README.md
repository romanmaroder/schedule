<h1 style="text-align: center;">Scheduler</h1>
<p style="text-align: center;">With the ability to maintain a client base, settlements with clients, cost of services</p>



## Installation

````
https://github.com/romanmaroder/schedule.git
````
<ul>
    <li>In the console
        <ul>
            <li>php init</li>
            <li>development</li>
            <li>composer install</li>
            <li>apply migrations</li>
        </ul>
    </li>
</ul>


## User

When installing the site by default, a user is created with the
- username: Admin Admin
- phone number: +7 (999) 999-99-99
- password: 12345678

To add the Admin role admin
- console controller yii role/assign
- Phone employee: +X (XXX) XXX-XX-XX +7 (999) 999-99-99
- Role: (admin,employee,manager,?): admin

Then you can log in

When creating a user, the empty password and email fields are generated automatically.
- Mail is generated randomly
- Default password is 12345678


Add
- service categories
- tags (optional)
- services
- roles
- rates
- prices

## Price

- Name - name of the price list
- Rate - the number that will be subtracted from the cost of the service
- Services - services that need to be added to the current price list


## Employee

You can create an employee in 2 ways

- from existing clients
    - in this case, this user will no longer be displayed in the list of clients
- create a new one

When you delete an employee, he automatically goes into the clients' category, without access rights and roles.

## Discount

- NO DISCOUNT
  * The client pays the full cost of the service according to the master’s price list.
  * Salary and income are calculated from the rates and price lists specified by the master.
  * If the rate and price list == 100%, the master’s salary is not calculated.
  
- MASTER DISCOUNT
  * The master indicates the cost of the discount.
  * The discount is deducted from the master’s salary.
  * The client pays the cost of the service at a discount.
  
- STUDIO DISCOUNT
  * The discount is divided in half between the master and the salon.
  * It is deducted from the master’s salary and the salon’s income.
  * The client pays the cost of the service at a discount.
  
- STUDIO DISCOUNT WITH MASTER WORK
  * The discount is deducted from the income.
  * The client pays the cost of the service at a discount.