<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Certificate</title>
  <link rel="stylesheet" href="/css/cc.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Geologica:wght@500;600&family=Heebo&family=Noto+Sans+HK:wght@100..900&family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Playfair+Display:ital,wght@0,400;0,700;1,400;1,700&family=Work+Sans:wght@400;500;700&display=swap" rel="stylesheet">


  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Geologica:wght@500;600&family=Heebo&family=Noto+Sans+HK:wght@100..900&family=Nunito:ital,wght@0,520;1,520&family=Playfair+Display:wght@558&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto+Slab:wght@100..900&family=Work+Sans:wght@488&display=swap" rel="stylesheet">

  <style>
    .heebo-h2 {
      font-family: "Heebo", sans-serif;
      font-optical-sizing: auto;
      font-weight: 800;
      font-style: normal;
    }

    .heebo-h3 {
      font-family: "Heebo", sans-serif;
      font-optical-sizing: auto;
      font-weight: 600;
      font-style: normal;
    }

    .heebo-h4 {
      font-family: "Heebo", sans-serif;
      font-optical-sizing: auto;
      font-weight: 800;
      font-style: normal;
    }

    .heebo-h5 {
      font-family: "Heebo", sans-serif;
      font-optical-sizing: auto;
      font-weight: 800;
      font-style: normal;
    }

    .roboto-slab-h4 {
      font-family: "Roboto Slab", serif;
      font-optical-sizing: auto;
      font-weight: 600;
      font-style: normal;
    }

    .namdhinggo-regular {
      font-family: "Namdhinggo", serif;
      font-weight: 800;
      font-style: normal;
    }

    .namdhinggo-regular-h2 {
      font-family: "Namdhinggo", serif;
      font-weight: 600;
      font-style: normal;
    }

    .montserrat-h2 {
      font-family: "Montserrat", sans-serif;
      font-optical-sizing: auto;
      font-weight: 200;
      font-style: normal;
    }

    .overpass-h2 {
      font-family: "Overpass", sans-serif;
      font-optical-sizing: auto;
      font-weight: 200;
      font-style: normal;
      margin: 1;
      /* Remove margin */
      padding: 5px;
      /* Remove padding */
    }

    .icon-container {
      position: absolute;
      top: 443px;
      left: 690px;
    }

    .date {
      position: absolute;
      top: 570px;
      left: 55px;
    }

    .instructor {
      position: absolute;
      top: 550px;
      left: 55px;
    }

    .code {
      position: absolute;
      top: 644px;
      left: 825px;
      font-family: "Roboto Slab", serif;
      font-optical-sizing: auto;
      font-weight: 600;
      font-style: normal;
      font-size: 12px;
    }
  </style>

</head>

<body>

  <div class="border">
    <div class="content" id="certificate">
      <div class="inner-content">
        <div class="logo ">
          <img src="/img/blcck.png" alt="" width="140">
        </div>

        <h3 class="namdhinggo-regular">CERTIFICATE OF COMPLETION</h3>
        <h3 class="overpass-h2 ">THIS CERTIFY THAT</h3>
        <p class="roboto-slab-h4">{{$name}}</p>
        <div>
          <h3 class="overpass-h2 ">HAS COMPLETED THE
            <strong style="text-transform: uppercase;">"{{$courseName}}"</strong>
            ONLINE COURSE
          </h3>
          <p class="heebo-custom instructor">INSTRUCTOR <strong style="text-transform: uppercase;">{{$Instructor}}</strong></p>
        </div>
        <p class="montserrat-h2 date">{{$date->format('F j, Y')}}</p>

        <p class="code" style="text-transform: uppercase;">LL{{$cid}}</p>
        <div class="icon-container">

          <img src="/img/oo.png" alt="" width="180">
        </div>
      </div>
    </div>
  </div>
  <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>

  <script>
    html2canvas(document.querySelector("#certificate")).then(canvas => {
      // Convert canvas to data URL
      var imgData = canvas.toDataURL('image/png');

      // Create a link element
      var link = document.createElement('a');
      link.download = 'certificate.png'; // Set the download attribute
      link.href = imgData; // Set the href attribute to the data URL

      // Trigger a click event on the link to initiate the download
      link.click();
    });
  </script>
</body>



</html>