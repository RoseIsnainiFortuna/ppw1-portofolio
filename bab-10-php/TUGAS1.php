<?php
// Mendefinisikan variabel profil
$nama = "Rose Isnaini Fortuna";
$nim = "25/556660/SV/25984"; 
$prodi = "Teknologi Rekayasa Perangkat Lunak"; 
$asal_kota = "Klaten"; 
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Profile - <?php echo $nama; ?></title>
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    />
    <style>
      body {
        margin: 0;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        background: radial-gradient(circle at center, #2e4a6a 0%, #172a45 100%);
        background-color: #172a45;
        background-attachment: fixed;
        overflow-x: hidden;
      }

      .text-accent {
        color: #ead8b1;
      }

      .text-secondary-custom {
        color: #cbd5e0;
      }

      .image-wrapper {
        display: inline-block;
        line-height: 0;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
      }

      .image-wrapper img {
        max-width: 400px;
        width: 100%;
        transition: transform 0.5s ease;
      }

      .image-wrapper:hover img {
        transform: scale(1.05);
      }

      .hero {
        padding: 30px 0;
        flex-grow: 1;
      }

      /* Style khusus untuk tabel profil agar menyatu dengan desain */
      .table-profile {
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(10px);
        border-radius: 15px;
        color: white;
        margin-top: 20px;
        border-collapse: separate;
        border-spacing: 0;
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.1);
      }

      .table-profile td {
        padding: 12px 15px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
      }

      .table-profile td:first-child {
        font-weight: bold;
        color: #1d2c5f;
        width: 30%;
      }

      footer {
        background-color: #112235;
        color: #ffffff;
        text-align: center;
        padding: 1rem;
        margin-top: auto;
      }

      footer p {
        margin-bottom: 0;
        opacity: 0.8;
      }

      @media (max-width: 768px) {
        .hero {
          text-align: center;
          padding: 60px 0;
        }
        .hero .row {
          flex-direction: column-reverse;
        }
        .display-4 {
          font-size: 2.8rem;
        }
      }
    </style>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-dark">
      <div class="container">
        <a class="navbar-brand fw-bold fs-3" href="#"
          ><span class="text-accent"><?php echo substr($nama, 0, 1); ?></span><?php echo substr($nama, 1, 3); ?></a
        >
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navMenu"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMenu">
          <ul class="navbar-nav ms-auto gap-3">
            <li class="nav-item"><a class="nav-link active" href="#">Home</a></li>
            <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
          </ul>
        </div>
      </div>
    </nav>

    <section class="hero d-flex align-items-center">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-md-6 text-white">
            <p class="fw-bold mb-2">Welcome to my portfolio</p>
            <h1 class="display-4 fw-bold mb-3">
              Hi, I'm <span class="text-accent"><?php echo $nama; ?></span>
            </h1>
            <h3 class="h5 mb-4 opacity-75">Full-Stack Web Developer</h3>
            
            <div class="table-responsive mb-4">
              <table class="table table-profile">
                <tr>
                  <td>Nama</td>
                  <td>: <?php echo $nama; ?></td>
                </tr>
                <tr>
                  <td>NIM</td>
                  <td>: <?php echo $nim; ?></td>
                </tr>
                <tr>
                  <td>Prodi</td>
                  <td>: <?php echo $prodi; ?></td>
                </tr>
                <tr>
                  <td>Asal Kota</td>
                  <td>: <?php echo $asal_kota; ?></td>
                </tr>
              </table>
            </div>
            <a href="#" class="btn btn-light rounded-pill px-4 py-2 fw-bold">Let's Talk</a>
          </div>

          <div class="col-md-6 text-center">
            <div class="image-wrapper">
              <img src="rosee.png" class="img-fluid" alt="<?php echo $nama; ?>" />
            </div>
          </div>
        </div>
      </div>
    </section>

    <footer>
      <p>&copy; <?php echo date("Y"); ?> <?php echo explode(' ', $nama)[0]; ?> - Personal Web.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>