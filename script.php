<script>

  let transferData = (arr1, arr2) => {
    arr1.forEach((el) => {
      arr2.push(el);
    });
  
    return arr2;
  }

  let searchTrigger = () => {
    // let inputMessage = document.getElementById('message2').value;
    let inputMessage = document.getElementById("person-search-input").value; // search value

    let areaFilter = document.getElementById('area-filter').value;
    let subjectFilter = document.getElementById('subject-filter').value; // subject filter

    // price filter logic
    let price = document.getElementById('price-filter').value;
    let priceFilter = ''; 

    if (price !== "price") {
      priceFilter = JSON.parse(price); // price filter
    }
    // end of price filter logic

    let searchData = {
      personName: inputMessage,
      price: priceFilter,
      subject: subjectFilter,
      area: areaFilter,
      verified: true
    };

    // send the JSON data via AJAX
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "http://localhost/tutor/Search/search_server.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
            // Handle the server response
            console.log(this.responseText);
            sessionStorage.setItem('searchResult', JSON.stringify(this.responseText));
            location.reload();
        }
    };

    // Send the AJAX request with the input data
    const data = "name=" + encodeURIComponent(JSON.stringify(searchData));
    xhr.send(data);
  }
  
  // request search results from backend using enter key
  document.getElementById("person-search-input").addEventListener("keydown", function(event) {
    if (event.key === 'Enter') {
      searchTrigger();
    }
  });

  // request search results from backend using apply filter button
  document.getElementById("filter-btn").addEventListener("click", (e) => {
    searchTrigger();
  });

  
  
  //===========================================================================
  
  // placeSearch({
  //   key: 'ck2OXUAJsF0iz999XGQ62jyXo8AXOVp7',
  //   container: document.querySelector('#person-search-input')
  // });
  
  L.mapquest.key = 'ck2OXUAJsF0iz999XGQ62jyXo8AXOVp7';
  
  let searchResult = JSON.parse(sessionStorage.getItem('searchResult'));
  var people = JSON.parse(searchResult) !== null ? JSON.parse(searchResult) : [];
  
  console.log(people);
  
  var map = L.mapquest.map('map', {
    center: [0, 0], // Default center coordinates
    layers: L.mapquest.tileLayer('map'),
    zoom: 12
  });
  
  var markers = []; // Array to store all the markers
  
  if (people.length > 0) {
    people.forEach(function(person) {
      let address = person.streetNumber + ' ' + person.streetName + ' ' + person.region;
  
      console.log(address);
  
      L.mapquest.geocoding().geocode(address, function createMarker(error, response) {
        var location = response.results[0].locations[0].latLng;
      
        var marker = L.mapquest.textMarker(location, {
          text: '<b>' + person.firstName + ' ' + person.lastName + '</b><br/>',
          subtext: address,
          position: 'right',
          type: 'marker',
          icon: {
            primaryColor: '#333333',
            secondaryColor: '#333333',
            size: 'md'
          }
        }).addTo(map);
      
        markers.push(marker);
      
        if (markers.length === people.length) {
          // Fit the map to show all the markers
          var markerGroup = new L.featureGroup(markers);
          map.fitBounds(markerGroup.getBounds());
        }
      });
    });
  } else {
    
    // Get the current location using the Geolocation API
    let address = 'Cape Peninsula University of Technology District 6 Cape Town';
  
    console.log(address);
  
    L.mapquest.geocoding().geocode(address, function createMarker(error, response) {
      var location = response.results[0].locations[0].latLng;
    
      var marker = L.mapquest.textMarker(location, {
        text: '<b>Cape Peninsula University of Technology</b><br/>',
        subtext: address,
        position: 'right',
        type: 'marker',
        icon: {
          primaryColor: '#333333',
          secondaryColor: '#333333',
          size: 'md'
        }
      }).addTo(map);
    
      markers.push(marker);
    
      // Fit the map to show all the markers
      var markerGroup = new L.featureGroup(markers);
      map.fitBounds(markerGroup.getBounds());
    });
  
    // navigator.geolocation.getCurrentPosition(function(position) {
    //   var currentLocation = {
    //     lat: position.coords.latitude,
    //     lng: position.coords.longitude
    //   };
  
    //   // Create a marker for the current location
    //   var currentLocationMarker = L.mapquest.textMarker(currentLocation, {
    //     text: 'You are here',
    //     position: 'right',
    //     type: 'marker',
    //     icon: {
    //       primaryColor: '#FF0000',
    //       secondaryColor: '#FF0000',
    //       size: 'md'
    //     }
    //   }).addTo(map);
  
    //   // Add the current location marker to the markers array
    //   markers.push(currentLocationMarker);
  
    //   // Fit the map to show all the markers
    //   var markerGroup = new L.featureGroup(markers);
    //   map.fitBounds(markerGroup.getBounds());
    // });
  
  }


  // document.getElementById("filter-btn").addEventListener('click', (e) => {
  //   location.href = "http://localhost/tutor/index.php?id=123";
  // });


  // send the results to PHP file so they can be rendered
  // const xhr = new XMLHttpRequest();
  // xhr.open("POST", "http://localhost/tutor/search.php", true);
  // xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  // xhr.onreadystatechange = function() {
  //     if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
  //         // Handle the server response
  //         console.log(this.responseText);
  //         // document.documentElement.innerHTML = this.responseText;
  //     }
  // };

  // // Send the AJAX request with the input data
  // const peopleData = "data=" + encodeURIComponent(JSON.stringify(people));
  // xhr.send(peopleData);

  // TODO => render the session data on html document (check line 170 for clue if forgotten)
  
  function renderData(data) {
    const container = document.getElementById('tutors');

    data.forEach((value) => {
      container.innerHTML += `
          <a href="http://localhost/tutor/details.php?id=${value.username}" class="tutor-class"><div class="tutor">
              <img src="./images/Screenshot (4).png" height="100vh" width="150px" alt="">
              <div class="desc">
                  <h2>${value.firstName} ${value.lastName}</h2>
                  <p>R${value.hourlyRate}/h</p>
              </div>
          </div></a>
      `;
    })
  }

  // Call the renderData function with the array as an argument
  renderData(people);
  
  
</script>
  
  