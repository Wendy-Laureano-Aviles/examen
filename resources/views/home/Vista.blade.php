<!DOCTYPE html>
<html lang="es-MX">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Vista principal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
</head>

<body>
    <div class="container">
        <div><h1>Examen</h1></div>
        <table class="table table-danger table-hover">
            <tr>
                <td>
                    <div>
                        Tiendas:
                    </div>
                    <select id="tienda_id">
                        <option value="0">--Seleccione una tienda--</option>
                        @foreach ($Tiendas as $tienda)
                            <option value="{{ $tienda->id }}">{{ $tienda->Nombre_Tienda }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <img src="{{ asset('img/default-profile.png') }}" alt="Imagen" height="100" id="imagen_tienda">
                </td>
            </tr>
            <tr>
                <td>
                    <div>Empleado:</div>
                    <select id="empleado_id">
                        <option value="">-- Selecciona un empleado --</option>
                    </select>
                </td>
                <td>
                    <img src="{{ asset('img/default-placeholder.png') }}" alt="Imagen" height="100" id="imagen_empleado">
                </td>
            </tr>
            <tr>
                <td>
                    <div id="producto_id"></div>
                </td>
                <td>
                    <div></div>
                </td>
            </tr>
            <tr>
                <td>
                    <div id="formulario_id"></div>
                </td>
                <td>
                    <div></div>
                </td>
            </tr>
        </table>
    </div>
    <div class="container">
        <div><h1>Ventas Realizadas</h1></div>
        <table class="table table-danger table-hover">
            <tr>
                <th>#</th>
                <th>Fecha</th>
                <th>Tienda</th>
                <th>Vendedor</th>
                <th>Producto</th>
                <th>Costo</th>
                <th>Cantidad</th>
                <th>Total</th>
            </tr>
            @php($number = 1)
            @foreach ($ventas as $venta)
                <tr>
                    <td>{{ $number }} @php($number = $number + 1)</td>
                    <td>{{ $venta->Fecha }}</td>
                    <td>
                    </td>
                    <td>{{ $venta->Usuarios_Id }}</td>
                    <td>{{ $venta->Producto_id }}</td>
                    <td>
                        @foreach ($productos as $producto)
                            $ {{ $producto->Costo }}
                        @endforeach
                    </td>
                    <td>{{ $venta->Cantidad }}</td>
                    <td>$ {{ $venta->Total }}</td>
                </tr>
            @endforeach
        </table>
    </div>

    @csrf
</body>
<script>
    $(document).ready(function() {
        $('#tienda_id').change(function() {
            var valtienda = $('#tienda_id').val();
            console.log("Tienda seleccionada: " + valtienda);
            if (valtienda == 0) {
                $('#empleado_id').html(
                    ' <select name="tienda" id="tienda_id"> <option value = "0" > -- Selecciona un empleado --'
                );
                $('#imagen_tienda').attr("src", 'img/default-placeholder.png');
            } else {
                $('#empleado_id').empty();
                $('#empleado_id').load("{{ route('datosEmpleados') }}?id_empleado=" + valtienda).serialize();

                var url = "/FotoTienda";

                var formData = new FormData();
                formData.append('_token', $('input[name=_token]').val());
                formData.append('id_tienda', valtienda);

                $.ajax({
                    type: "POST",
                    url: url,
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        $("#imagen_tienda").attr("src", "img/" + data);
                    },
                    error: function(e) {
                        console.log(e);
                    }
                });
            }
        });
    });
</script>

</html>
