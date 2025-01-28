<footer id="footer" class="bg-black text-white py-5">
    <div class="container-sm">
      <div class="row g-md-5 my-5">
        <div class="col-md-4">
          <div class="info-box">
            <img src="vendor/img/logo-branco.png" class="img-fluid">
            <!--<p class="py-4">
              Subscribe to newsletter to get some updates related with branding, designs and more.
            </p>-->
            <div class="social-links">
              <svg class="skype" width="24" height="24">
                <use xlink:href="#skype"></use>
              </svg>
              <svg class="snapchat" width="24" height="24">
                <use xlink:href="#snapchat"></use>
              </svg>
              <svg class="telegram" width="24" height="24">
                <use xlink:href="#telegram"></use>
              </svg>
              <svg class="tumblr" width="24" height="24">
                <use xlink:href="#tumblr"></use>
              </svg>
              <svg class="twitter" width="24" height="24">
                <use xlink:href="#twitter"></use>
              </svg>
              <svg class="whatsapp" width="24" height="24">
                <use xlink:href="#whatsapp"></use>
              </svg>
              <svg class="github" width="24" height="24">
                <use xlink:href="#github"></use>
              </svg>
              <svg class="facebook" width="24" height="24">
                <use xlink:href="#facebook"></use>
              </svg>
              <svg class="messenger" width="24" height="24">
                <use xlink:href="#messenger"></use>
              </svg>
              <svg class="behance" width="24" height="24">
                <use xlink:href="#behance"></use>
              </svg>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="row">
            <div class="col-6">
              <ul class="list-unstyled">
                <li>
                  <a href="https://fepacoc.com/" class="text-decoration-none text-white" target="_blank">Fepacoc</a>
                </li>
                <!--<li>
                  <a class="text-decoration-none text-white" href="#">Sobre</a>
                </li>
                <li>
                  <a class="text-decoration-none text-white" href="index.html">Team</a>
                </li>
                <li>
                  <a class="text-decoration-none text-white" href="index.html">Portfolio</a>
                </li>-->
              </ul>
            </div>
            <div class="col-6">
              <h6>
                <a class="text-decoration-none text-white" href="index.html">Blog</a>
              </h6>
              <h6>
                <a class="text-decoration-none text-white" href="index.html">Contact</a>
              </h6>
            </div>
          </div>
        </div>
        <div class="col-md-5">
          <p>
            Metodologia exclusiva, construída para facilitar sua gestão e melhorar a performance da sua empresa.
          </p>
          <h3>
            <a href="mailto:suporte@fepacoc.com.br" class="text-white text-decoration-none">suporte@fepacoc.com.br</a>
          </h3>
        </div>
      </div>
      <div class="row">
        <p>Área de Membros - Fepacoc. Criado pelo time <a href="https://vempublicar.com/" class="text-white" target="_blank">Vempublicar</a>. Versão Beta 1.0.02 </p>
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