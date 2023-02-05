<!-- HTML Form to get search term from user -->
<form>
  <input type="text" id="search_term">
  <button type="button" id="search_btn">Search</button>
</form>

<!-- Display search results in a table -->
<table id="search_results">
  <thead>
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Email</th>
    </tr>
  </thead>
  <tbody>

  </tbody>
</table>

<!-- AJAX call to search.php -->
<script>
  document.getElementById("search_btn").addEventListener("click", function() {
    // Get search term from form
    var search_term = document.getElementById("search_term").value;

    // Create an XMLHttpRequest object
    var xhr = new XMLHttpRequest();

    // Set up the request
    xhr.open("POST", "search.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    // Send the request
    xhr.send("search_term=" + search_term);

    // Handle the response
    xhr.onreadystatechange = function() {
      if (xhr.readyState == 4 && xhr.status == 200) {
        // Parse the JSON response
        var response = JSON.parse(xhr.responseText);

        // Clear the search results table
        document.getElementById("search_results").innerHTML = "";

        // Loop through the results and add them to the table
        for (var i = 0; i < response.length; i++) {
          var tr = document.createElement("tr");
          var td_id = document.createElement("td");
          td_id.innerHTML = response[i].id;
          tr.appendChild(td_id);
          var td_name = document.createElement("td");
          td_name.innerHTML = response[i].name;
          tr.appendChild(td_name);
          var td_email = document.createElement("td");
          td_email.innerHTML = response[i].email;
          tr.appendChild(td_email);
          document.getElementById("search_results").appendChild(tr);
        }
      }
    };
  });
</script>
<?php
// Connect to the database
$conn = mysqli_connect("host", "username", "password", "database");

// Check the connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Get the search term from the POST request
$search_term = mysqli_real_escape_string($conn, $_POST["search_term"]);

// Query the database
$query = "SELECT * FROM users WHERE name LIKE '%$search_term%' OR email LIKE '%$search_term%'";
$result = mysqli_query($conn, $query);

// Check if any results were returned
if (mysqli_num_rows($result) > 0) {
  // Fetch the results and store them in an array
  $results = array();
  while ($row = mysqli_fetch_assoc($result)) {
    $results[] = $row;
  }

  // Return the results as a JSON string
  echo json_encode($results);
} else {
  // Return an empty JSON string if no results were found
  echo json_encode(array());
}

// Close the database connection
mysqli_close($conn);
