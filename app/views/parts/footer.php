<footer id="footer" class="bg-black text-white py-5">
    <div class="container-sm">
      <div class="row g-md-5 my-5">
        <div class="col-md-4">
          <div class="info-box">
            <img src="vendor/img/logo-branco.png" style="height:30px" class="img-fluid">            
          </div>
        </div>
        <div class="col-md-3">
          <div class="row">
            <div class="col-6">
              <ul class="list-unstyled">
                <li>
                  <a href="https://fepacoc.com/" class="text-decoration-none text-white" target="_blank">Fepacoc</a>
                </li>
              </ul>
            </div>
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
  </footer>

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