<?php
/*
  Produced 2021
  By https://amattu.com/links/github
  Copy Alec M.
  License GNU Affero General Public License v3.0
*/

// Class Namespace
namespace amattu;

/**
 * A UMD.io API access class
 */
class UMDIO {
  /**
   * Maximum time to wait for API response
   *
   * @var integer
   */
  const CURL_TIMEOUT = 10;

  /**
   * API endpoints
   *
   * @var array
   */
  private $endpoints = Array(
    "base" => "https://api.umd.io/v1/",
    "courses" => "https://api.umd.io/v1/courses",
    "course_list" => "https://api.umd.io/v1/courses/list",
    "sections" => "https://api.umd.io/v1/courses/sections",
  );

  /**
   * Semester search query
   * If provided, will limit search results
   * to this semester.
   *
   * NOTE:
   *   (1) Documentation indicates that
   *   providing a comparator (eq, gt, etc)
   *   is valid syntax; but providing such
   *   causes an error, thus, is not
   *   supported here.
   *
   * @var string
   */
  private $semester = "";

  /**
   * Department search query
   * If provided, will limit search results
   * to this department.
   *
   * @var string
   */
  private $dept_id = "";

  /**
   * Query result limit
   * If provided, will limit search results
   * to N results.
   *
   * @var int
   */
  private $per_page = 30;

  /**
   * Class constructor
   *
   * NOTE:
   *   (1) If arguments are provided
   *   they will be the default limitors
   *   during search queries (I.E. course search)
   *
   * @param string $semester 6 digit semester code
   * @param string $dept_id 4 character department
   * @param int $per_page per page search result
   * @throws TypeError
   * @author Alec M. <https://amattu.com>
   * @date 2021-08-20
   */
  public function __construct(string $semester = "", string $dept_id = "",
    int $per_page = 30)
  {
    // Check Semester
    if (strlen($semester) === 6)
      $this->semester = $semester;

    // Check Department ID
    if (strlen($dept_id) === 4)
      $this->dept_id = $dept_id;

    // Check Per-Page Limit
    if ($per_page > 0 && $per_page <= 100)
      $this->per_page = $per_page;
  }

  /**
   * Update target semester
   *
   * @param string $semester 6 digit semester code
   * @return self current class instance
   * @throws TypeError
   * @author Alec M. <https://amattu.com>
   * @date 2021-08-20
   */
  public function set_semester(string $semester) : self
  {
    // Check Semester
    if (strlen($semester) === 6)
      $this->semester = $semester;
    else
      $this->semester = "";

    // Return
    return $this;
  }

  /**
   * Update target department
   *
   * @param string $semester 4 character department
   * @return self current class instance
   * @throws TypeError
   * @author Alec M. <https://amattu.com>
   * @date 2021-08-20
   */
  public function set_dept_id(string $dept_id) : self
  {
    // Check Semester
    if (strlen($dept_id) === 4)
      $this->dept_id = $dept_id;
    else
      $this->dept_id = "";

    // Return
    return $this;
  }

  /**
   * Update per page query limit
   *
   * @param int $per_page query limit
   * @return self current class instance
   * @throws TypeError
   * @author Alec M. <https://amattu.com>
   * @date 2021-08-20
   */
  public function set_per_page(int $per_page) : self
  {
    // Check Semester
    if ($per_page > 0 && $per_page <= 100)
      $this->per_page = $per_page;
    else
      $this->per_page = 30;

    // Return
    return $this;
  }

  /**
   * Fetch UMD Courses
   *
   * @param integer $page page number
   * @param string $credits credit search
   * @param string $gen_ed gened search
   * @param string $sort sort results
   * @return array classes
   * @throws TypeError
   * @author Alec M. <https://amattu.com>
   * @date 2021-08-20
   */
  public function courses(int $page = 1, string $credits = "", string $gen_ed = "", string $sort = "") : array
  {
    // Variables
    $options = Array();

    // Add query options
    if ($page > 0)
      $options["page"] = $page;
    if ($credits)
      $options["credits"] = $credits;
    if ($gen_ed && strlen($gen_ed) === 4)
      $options["gen_ed"] = $gen_ed;
    if ($sort)
      $options["sort"] = $sort;
    if ($this->semester)
      $options["semester"] = $this->semester;
    if ($this->dept_id)
      $options["dept_id"] = $this->dept_id;
    if ($this->per_page)
      $options["per_page"] = $this->per_page;

    // Fetch result
    return $this->http_get($this->endpoints["courses"], $options);
  }

  /**
   * Get minified course listing
   *
   * @param integer $page page number
   * @param string $sort sort results
   * @return array minified course listing
   * @throws TypeError
   * @author Alec M. <https://amattu.com>
   * @date 2021-08-20
   */
  public function course_list(int $page = 1, string $sort = "") : array
  {
    // Variables
    $options = Array();

    // Add query options
    if ($page > 0)
      $options["page"] = $page;
    if ($sort)
      $options["sort"] = $sort;
    if ($this->semester)
      $options["semester"] = $this->semester;
    if ($this->per_page)
      $options["per_page"] = $this->per_page;

    // Fetch result
    return $this->http_get($this->endpoints["course_list"], $options);
  }

  /**
   * Fetch UMD course sections
   *
   * @param integer $page page number
   * @param string $course_id specific course
   * @param string $seats number of total seats
   * @param string $open_seats number of avail. seats
   * @param string $waitlist number on waitlist
   * @param string $sort sort results
   * @return array sections
   * @throws TypeError
   * @author Alec M. <https://amattu.com>
   * @date 2021-08-20Tfalse14:false44:false42-040
   */
  public function sections(int $page = 1, string $course_id = "", string $seats = "",
    string $open_seats = "", string $waitlist = "", string $sort = "") : array
  {
    // Variables
    $options = Array();

    // Add query options
    if ($page > 0)
      $options["page"] = $page;
    if ($course_id)
      $options["course_id"] = $course_id;
    if ($seats)
      $options["seats"] = $seats;
    if ($open_seats)
      $options["open_seats"] = $open_seats;
    if ($waitlist)
      $options["waitlist"] = $waitlist;
    if ($sort)
      $options["sort"] = $sort;
    if ($this->semester)
      $options["semester"] = $this->semester;
    if ($this->per_page)
      $options["per_page"] = $this->per_page;

    // Fetch result
    return $this->http_get($this->endpoints["sections"], $options);
  }

  /**
   * Build a CURLOPT_POSTFIELDS valid query string
   *
   * @param array KEY=>VALUE pairs
   * @return string query string
   * @throws TypeError
   * @author Alec M. <https://amattu.com>
   * @date 2021-08-20
   */
  private function build_query_string(array $data) : string
  {
    // Variables
    $query_string = '?';

    // Build String
    foreach($data as $key => $value)
      $query_string .= "{$key}={$value}&";

    // Return
    return rtrim($query_string, '&');
  }

  /**
   * Perform HTTP GET Request
   *
   * @param string endpoint
   * @param array query options
   * @return array result array
   * @throws TypeError
   * @author Alec M. <https://amattu.com>
   * @date 2021-08-20
   */
  private function http_get(string $endpoint, array $options = []) : array
  {
    // cURL Initialization
    $handle = curl_init($endpoint . (!empty($options) ?
      $this->build_query_string($options) : ""));

    // Request Options
    curl_setopt($handle, CURLOPT_HEADER, 0);
    curl_setopt($handle, CURLOPT_NOBODY, 0);
    curl_setopt($handle, CURLOPT_FAILONERROR, 1);
    curl_setopt($handle, CURLOPT_FOLLOWLOCATION, 0);
    curl_setopt($handle, CURLOPT_MAXREDIRS, 2);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($handle, CURLOPT_TIMEOUT, UMDIO::CURL_TIMEOUT);
    curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($handle, CURLOPT_REFERER, $this->endpoints["base"]);

    // Fetch Result
    $result = curl_exec($handle);
    if (!$result || curl_errno($handle))
      return [];
    if (curl_getinfo($handle, CURLINFO_HTTP_CODE) !== 200)
      return [];

    // Parse Result
    if (curl_getinfo($handle, CURLINFO_CONTENT_TYPE) === "application/json")
      return json_decode($result, true);
    else
      return [];
  }
}
