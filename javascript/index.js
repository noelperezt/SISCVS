var working = false;
$('.login').on('submit', function(e) {
  e.preventDefault();
  if (working) return;
  working = true;
  var $this = $(this),
    $state = $this.find('button > .state');
  $this.addClass('Cargando');
  $state.html('Autenticando');
  setTimeout(function() {
    $this.addClass('ok');
    $state.html('Bienvenido!');
    setTimeout(function() {
      $state.html('Iniciar Sesión');
      $this.removeClass('ok cargando');
      working = false;
    }, 4000);
  }, 3000);
});