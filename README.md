# Introduction
This is a simple [UMD.io](https://umd.io) API wrapper built with PHP. See the usage section below.

# Usage
## Notes
- All functions below are error safe, and always return an empty array on error
- **Unless otherwise stated** all arguments are OPTIONAL

## Setup
Include the required files and setup a handle.

```PHP
// Files
require("classes/UMDIO.class.php");

// Setup Wrapper
$wrapper = new amattu\UMDIO();
```

Optional arguments:
- `string` semester limit search results to specified semester (I.E. `202108` for Fall 2021)
- `string` department_id limit search results to specific department (I.E. `CMSC` for computer science)
- `int` per_page limits search results to N results per page

## Setters
All three of these functions support chaining.

I.E.
```PHP
$wrapper->set_dept_id("INST")->set_per_page(10)->set_semester("202108");
```

### set_semester(string = "")
Change/remove the selected semester.

```PHP
$wrapper->set_semester("SEMESTER_ID");
```

A empty value will be interpreted as removing semester_id.

### set_per_page(int = 30)
Change/default the per_page query limit. Limited to a range from 1-100.

```PHP
$wrapper->set_per_page(10);
```

### set_dept_id(string = "")
Change/remove the selected department.

```PHP
$wrapper->set_dept_id("DEPT_ID");
```

A empty value will be interpreted as removing dept_id.

## courses(int $page, string $credits, string $gen_ed, string $sort)
Fetch all courses University-wide. See PHPDoc for a more detailed description.

```PHP
$courses = $wrapper->courses();

print_r($courses);
```

Output
```JSON
tbd
```

## course_list(int $page, string $sort)
Fetch a simple Course_ID, Course_Name pair for all courses offered University-wide. See PHPDoc for description.

```PHP
print_r($wrapper->course_list());
```

Output
```JSON
tbd
```

## sections(int $page, string $course_id, string $seats, string $open_seats, string $waitlist, string $sort)
Get a full listing of course sections University-wide. Only actually useful if you provide a `course_id`.

```PHP
print_r($wrapper->sections());
```

Output
```JSON
tbd
```

## section(string $section)
Get all details about a certain course section.

```PHP
print_r($wrapper->section("AASP100-0101"));
```

Output
```JSON
Array
(
  [0] => Array
  (
    ["course"] => AASP100
    ["section_id"] => AASP100-0101
    ["semester"] => 202108
    ["number"] => 0101
    ["seats"] => 31
    ["meetings"] => Array
    (
      [0] => Array
      (
          ["days"] => MWF
          ["room"] => 1132
          ["building"] => TYD
          ["classtype"] =>
          ["start_time"] => 10:00am
          ["end_time"] => 10:50am
      )

      ...
    )
    ["open_seats"] => 0
    ["waitlist"] => 05
    ["instructors"] => Array
    (
      [0] => ...
    )
  )
)
```

## course(string $course_id)
Get all details about a specific course

```PHP
print_r($wrapper->course("INST414"));
```

Output
```JSON
Array
(
  [0] => Array
  (
    ["course_id"] => INST414
    ["semester"] => 202108
    ["name"] => Data Science Techniques
    ["dept_id"] => INST
    ["department"] => Information Studies
    ["credits"] => 3
    ["description"] => An exploration of how to extract insights from large-scale datasets. The course will cover the complete analytical funnel from data extraction and cleaning to data analysis and insights interpretation and visualization. The data analysis component will focus on techniques in both supervised and unsupervised learning to extract information from datasets. Topics will include clustering, classification, and regression techniques.  Through homework assignments, a project, exams and in-class activities, students will practice working with these techniques and tools to extract relevant information from structured and unstructured data.
    ["grading_method"] => Array
    (
      [0] => Regular
      [1] => Audit
    )

    [gen_ed] => Array
    (
    )

    [core] => Array
    (
    )

    [relationships] => Array
    (
      ["coreqs"] =>
      ["prereqs"] => 1 course with a minimum grade of C- from (INST201, INST301); and minimum grade of C- in INST126, INST314, STAT100, MATH115, and PSYC100.
      ["formerly"] =>
      ["restrictions"] => Must be in Information Science program.
      ["additional_info"] =>
      ["also_offered_as"] =>
      ["credit_granted_for"] =>
    )

    [sections] => Array
    (
      [0] => INST414-0101
      [1] => INST414-0102
      [2] => INST414-0103
    )
  )
)
```

## semesters()
Return a single dimensional array of supported schedule-of-classes semesters by [UMD.io](https://umd.io). Formatted in `YYYYMM` date format.

No arguments.
```PHP
print_r($wrapper->semesters());
```

Output
```JSON
Array
(
  [0] => 201708
  [1] => 201712
  [2] => 201801
  ...
)
```

## departments()
Returns a two-dimensional array of University of Maryland departments.

No arguments.
```PHP
print_r($wrapper->departments());
```

Output
```JSON
Array
(
    [0] => Array
    (
      ["dept_id"] => AAPS
      ["department"] => Academic Achievement Programs
    )

    ...
)
```

## professors(string $name, string $course_id)
Fetch an array of professors by either their full name or a course ID.

By `name`
```PHP
print_r($wrapper->professors("LaRia Rogers"));
```

By `course_id`
```PHP
print_r($wrapper->professors("", "CMSC216"));
```

Output
```JSON
Array
(
  [0] => Array
  (
    ["name"] => LaRia Rogers
    ["taught"] => Array
    (
      [0] => Array
      (
          ["course_id"] => INST208M
          ["semester"] => 202001
      )

      [1] => Array
      (
          ["course_id"] => INST352
          ["semester"] => 202001
      )

      ...
    )
  )
)
```

## majors()
Returns a multi-dimensional array of UMD majors.

No arguments.
```PHP
print_r($wrapper->majors());
```

Output
```JSON
Array
(
  [0] => Array
  (
      ["major_id"] => 118
      ["name"] => Accounting
      ["college"] =>   Robert H. Smith School of Business
      ["url"] => https://www.rhsmith.umd.edu/programs/undergraduate/academics/academic-majors
  )

  ...
)
```

## buildings()
Get full list of buildings on the University of Maryland campus

```PHP
print_r($wrapper->buildings());
```

Output
```JSON
Array
(
  [0] => Array
  (
      ["name"] => 251 North
      ["code"] =>
      ["id"] => 251
      ["long"] => -76.949609032536
      ["lat"] => 38.99274005
  )

  [1] => Array
  (
      ["name"] => 94th Aero Squadron
      ["code"] =>
      ["id"] => F08
      ["long"] => -76.921012271141
      ["lat"] => 38.9781702
  )

  ...
)
```

## building(string $building_id)
Get details about a particular UMD building.

```PHP
print_r($wrapper->building("F01"));
```

Output
```JSON
Array
(
  ["data"] => Array
  (
      [0] => Array
      (
          ["name"] => A Harvey Wiley Federal Building FDA
          ["code"] => FDA
          ["id"] => F01
          ["long"] => -76.926196584649
          ["lat"] => 38.9770124
      )
  )
  ["count"] => 1
)
```

## bus_routes()
Get full listing of UMD bus routes.

No arguments
```PHP
print_r($wrapper->bus_routes());
```

Output
```JSON
Array
(
  [0] => Array
  (
      [route_id] => 104
      [title] => 104 College Park Metro
  )

  ...
)
```

## bus_route(string $route_id)
Returns a comprehensive collection of details about a bus route.

```PHP
print_r($wrapper->bus_route("104"));
```

Output (Substantially redacted due to amount of data returned)
```JSON
Array
(
  [0] => Array
  (
    ["route_id"] => 104
    ["title"] => 104 College Park Metro
    ["lat_max"] => 38.9899498
    ["lat_min"] => 38.9755375
    ["long_max"] => -76.9266478
    ["long_min"] => -76.9407719
    ["stops"] => Array
    (
      [0] => regdrgar_d
      [1] => campmath
      [2] => paingree
      [3] => painrhod
      [4] => cpmetro_d
      [5] => painrhod_in
      [6] => painglen
    )

    ...
)
```
