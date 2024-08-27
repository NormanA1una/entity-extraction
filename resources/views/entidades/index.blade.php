<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Extracción de Entidades</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <div class="container mt-5">
        <h1>Extracción de Entidades Predominantes</h1>
        <form id="entidadForm">
            <div class="form-group">
                <label for="url">Ingresa una URL:</label>
                <input type="text" class="form-control" id="url" name="url" required>
            </div>
            <button type="submit" class="btn btn-primary">Enviar</button>
        </form>
        <div id="resultados" class="mt-5">
            <h2>Resultados</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>Entidad</th>
                        <th>Relevancia</th>
                    </tr>
                </thead>
                <tbody id="tabla-resultados">
                    <!-- Resultados serán añadidos aquí dinámicamente -->
                </tbody>
            </table>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#entidadForm').on('submit', function(event) {
                event.preventDefault();

                var url = $('#url').val();

                $.ajax({
                    url: '/extraer-entidades',
                    method: 'POST',
                    data: {
                        url: url,
                        _token: '{{ csrf_token() }}'
                    },

                    success: function(response) {
                        $('#tabla-resultados').empty();
                        response.forEach(function(entidad) {
                            $('#tabla-resultados').append('<tr><td>' + entidad.name + '</td><td>' + entidad.salience + '</td></tr>');
                        });
                    },

                    error: function() {
                        alert('Ocurrió un error al procesar la solicitud.');
                    }
                });
            });
        });
    </script>
</body>

</html>