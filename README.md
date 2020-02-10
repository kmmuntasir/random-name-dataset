# random-name-dataset
This is a dataset repository generated from data found in https://catalog.data.gov/dataset/baby-names-from-social-security-card-applications-national-level-data

#### I needed some random names for a project, so I made this repo for my need and for anyone else who might need something like this.




## How to run
- Clone this repo to your local server
- Set db config in `/app/config/db.php`
- Execute `test.sql` in your db
- Visit this link: http://localhost/random-name-dataset/?gender=male
(This is a relative link, might change depending on your directory name)

By default it will show 100 male names
You can generate female names by changing the get parameter `gender` value to `female`

The tables `male_unique_names` and `female_unique_names` contain 41,475 and 56,027 unique single names respectively.
These names are used as dataset when generating the full names.

The tables `male_fullnames` and `female_fullnames` contain 300,000 unique full names (first and last names) each.
If you want to generate more, just make these changes in `/app/controller/main.php`: 

- Uncomment line 125 and 126
- Comment line 127
- Change the second parameter of the function call `generate_unique_nameset()` in line 121 to your liking.

