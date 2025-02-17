window.onload = function() {
      var h1Element = document.querySelector('h3');
      var request = new XMLHttpRequest();
      request.open('HEAD', 'http://qwq.tangdouz.com/cdn/index.html', true);
      request.onreadystatechange = function() {
        if (request.readyState === 2 && request.status === 200) {
          var dateString = request.getResponseHeader('Last-Modified');
          var date = new Date(dateString);
          var year = date.getFullYear();
          var month = ("0" + (date.getMonth() + 1)).slice(-2);
          var day = ("0" + date.getDate()).slice(-2);
          var hours = ("0" + date.getHours()).slice(-2);
          var minutes = ("0" + date.getMinutes()).slice(-2);
          var formattedDate = "最近于"+year + "-" + month + "-" + day + " " + hours + ":" + minutes+"更新";
          h1Element.innerText = formattedDate;
        }
      };
      request.send();
    };