
<!-- <footer id="footer" class="dark-mode text-white py-5" >
    <div class="container-sm">
      <div class="row g-md-5 my-5">
        <div class="col-md-4">
          <div class="info-box">
            <a href="https://fepacoc.com/" class="text-decoration-none text-white" target="_blank">
            <img src="vendor/img/logo-branco.png" style="height:35px" class="img-fluid"></a>        
          </div>
        </div>
        <div class="col-md-3">
          <div class="row">
            <div class="col-6">
              <h6>
                <a class="text-decoration-none text-white" href="https://fepacoc.com.br/blog">Blog</a>
              </h6>
              <h6>
                <a class="text-decoration-none text-white" href="https://fepacoc.com.br/suporte">Suporte</a>
              </h6>
            </div>
          </div>
        </div>
        <div class="col-md-5">
          <small>
            Metodologia exclusiva, construída para facilitar sua gestão e melhorar a performance da sua empresa.
          </small>
          <h5>
            <a href="mailto:suporte@fepacoc.com.br" class="text-white text-decoration-none">suporte@fepacoc.com.br</a>
          </h5>
        </div>
      </div>
      <div class="row">
        <span>Área de Membros - Fepacoc. Criado pelo time <a href="https://vempublicar.com/" class="text-white" target="_blank">Vempublicar</a>. Versão Beta 1.0.02 </span>
      </div>
    </div>
  </footer> -->

<script src="vendor/js/jquery-1.11.0.min.js"></script> 
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
    crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script> 
<script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script>
<script src="vendor/js/plugins.js"></script>
<script src="vendor/js/script.js"></script>
<script type="text/javascript" src="vendor/js/lightbox.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        setTimeout(function() {
            document.getElementById("footer").style.display = "block";
        }, 3000); // Espera 1 segundo (1000ms) antes de exibir o footer
    });
</script>

  <script>
  if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('/sw.js')
      .then((registration) => {
        console.log('Service Worker registrado com sucesso:', registration);
      })
      .catch((error) => {
        console.log('Falha ao registrar o Service Worker:', error);
      });
  }
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const themeToggle = document.getElementById("themeToggle");
        const body = document.body;

        // Verifica o tema salvo no localStorage
        const savedTheme = localStorage.getItem("theme");
        if (savedTheme === "dark") {
            body.classList.add("dark-mode");
            themeToggle.innerHTML = '<i class="fas fa-moon"></i>';
        }

        // Alterna o tema
        themeToggle.addEventListener("click", function() {
            body.classList.toggle("dark-mode");
            const isDarkMode = body.classList.contains("dark-mode");
            localStorage.setItem("theme", isDarkMode ? "dark" : "light");
            themeToggle.innerHTML = isDarkMode ?
                '<i class="fas fa-moon"></i>' :
                '<i class="fas fa-sun"></i>';
        });
    });
</script>