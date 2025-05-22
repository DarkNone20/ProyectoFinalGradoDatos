<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="shortcut icon"
        href="https://static.vecteezy.com/system/resources/thumbnails/000/595/791/small/20012019-26.jpg">
    <link rel="stylesheet" href="{{ asset('assets/style-home.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Home</title>
</head>

<body>
    <!-- Botón de hamburguesa (solo visible en móviles) -->
    <button class="menu-toggle" id="menuToggle">
        <span></span>
        <span></span>
        <span></span>
    </button>

    <nav>
        <ul id="navMenu">
            <li class="logo"><img src="{{ asset('Imagenes/Logo5.png') }}" alt="Logo"></li>
            <div class="Menu">
                <li><a href="{{ asset('home') }}"><i class="fa fa-home"></i>&nbsp;<img
                            src="{{ asset('Imagenes/Home 2.0.png') }}" alt="inicio"> Home</a></li>
                <li><a href="{{ asset('usuarios') }}"><i class="fa fa-users"></i>&nbsp;<img
                            src="{{ asset('Imagenes/Usuarios 2.0.png') }}" alt="user"> Usuarios</a></li>
                <li><a href="{{ asset('grupos') }}"><i class="fa fa-phone"></i>&nbsp; <img
                            src="{{ asset('Imagenes/Grupos 2.0.png') }}" alt="grupos"> Grupos</a></li>
                <li><a href="{{ asset('equipos') }}"><i class="fa fa-phone"></i>&nbsp;<img
                            src="{{ asset('Imagenes/Equipos 2.0.png') }}" alt="equipos"> Equipos</a></li>
                <li><a href="{{ asset('prestamos') }}"><i class="fa fa-users"></i>&nbsp;<img
                            src="{{ asset('Imagenes/Prestamos 2.0.png') }}" alt="prestamos"> Prestamos</a></li>
                <li><a href="{{ route('reportes.index') }}"><img src="{{ asset('Imagenes/Reportes 2.0.png') }}" 
                            alt="reportes"> Reportes</a></li>
            </div>

            <div class="Prueba">
                <li><a href="{{ asset('/') }}"><i class="fa fa-phone"></i>&nbsp; <img
                            src="{{ asset('Imagenes/logout.png') }}" alt="login">
                        Logout</a></li>
            </div>
        </ul>
    </nav>

    <div class="wrapper">
        <div class="section">
            <div class="Encabezado">
                <div class="Titulo">
                    <h1>Sistema de Administrador de Préstamo de Portatiles</h1>
                </div>

                <div class="userLogo">
                    <img src="../../Imagenes/dos3.png">
                </div>
                <div class="Usuario">
                    <p>{{ $usuarioAutenticado->Alias ?? 'Invitado' }}</p>
                </div>
                <br>
            </div>

            <div class="Group">
                <div class="Clase1">
                    <div class="Clase1-left">
                        <img src="{{ asset('Imagenes/Usuarios 2.png') }}" alt="user">
                    </div>
                    <div class="Clase1-Right">
                        <a href="{{ asset('usuarios') }}">
                            <h1>Usuarios</h1>
                        </a>
                    </div>
                </div>
                <div class="Clase2">
                    <div class="Clase2-left">
                        <img src="{{ asset('Imagenes/team.png') }}" alt="team">
                    </div>
                    <div class="Clase2-Right">
                        <a href="{{ asset('grupos') }}">
                            <h1>Grupos</h1>
                        </a>
                    </div>
                </div>
                <div class="Clase3">
                    <div class="Clase3-left">
                        <img src="{{ asset('Imagenes/pc.png') }}" alt="equipos">
                    </div>
                    <div class="Clase3-Right">
                        <a href="{{ asset('equipos') }}">
                            <h1>Equipos</h1>
                        </a>
                    </div>
                </div>
                <div class="Clase4">
                    <div class="Clase4-left">
                        <img src="{{ asset('Imagenes/prest.png') }}" alt="prestamos">
                    </div>
                    <div class="Clase4-Right">
                        <a href="{{ asset('prestamos') }}">
                            <h1>Prestamos</h1>
                        </a>
                    </div>
                </div>
            </div>

            <div class="Principal">
                <div class="Principal-Left">
                    <h2>Préstamos de Portátiles Año - {{ date('Y') }}</h2>
                    <div class="chart-container" style="position: relative; height:600px; width:100%">
                        <canvas id="graficaPrestamosMensuales"></canvas>
                    </div>
                    
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const ctx = document.getElementById('graficaPrestamosMensuales').getContext('2d');
                            
                            function generarColoresVariables(cantidad) {
                                const colores = [];
                                const hueStep = 360 / cantidad;
                                
                                for (let i = 0; i < cantidad; i++) {
                                    const hue = Math.round((i * hueStep) % 360);
                                    const baseColor = `hsla(${hue}, 80%, 85%, 0.8)`;
                                    const borderColor = `hsla(${hue}, 55%, 50%, 1)`;
                                    const hoverColor = `hsla(${hue}, 85%, 70%, 1)`;
                                    
                                    colores.push({
                                        base: baseColor,
                                        border: borderColor,
                                        hover: hoverColor
                                    });
                                }
                                return colores;
                            }
                            
                            const colores = generarColoresVariables(12);
                            
                            new Chart(ctx, {
                                type: 'bar',
                                data: {
                                    labels: @json($meses),
                                    datasets: [{
                                        label: 'Préstamos',
                                        data: @json($prestamosPorMes),
                                        backgroundColor: colores.map(c => c.base),
                                        borderColor: colores.map(c => c.border),
                                        borderWidth: 2,
                                        borderRadius: 6,
                                        hoverBackgroundColor: colores.map(c => c.hover),
                                        hoverBorderColor: colores.map(c => c.border),
                                        hoverBorderWidth: 3
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    plugins: {
                                        legend: {
                                            display: false
                                        },
                                        tooltip: {
                                            enabled: true,
                                            mode: 'nearest',
                                            intersect: true,
                                            backgroundColor: 'rgba(0,0,0,0.9)',
                                            titleFont: {
                                                size: 14,
                                                weight: 'bold'
                                            },
                                            bodyFont: {
                                                size: 13
                                            },
                                            displayColors: true,
                                            callbacks: {
                                                title: function(tooltipItems) {
                                                    return tooltipItems[0].label;
                                                },
                                                label: function(context) {
                                                    return `Total: ${context.raw} préstamo${context.raw !== 1 ? 's' : ''}`;
                                                },
                                                afterLabel: function(context) {
                                                    return `Mes: ${context.label}`;
                                                }
                                            }
                                        }
                                    },
                                    scales: {
                                        y: {
                                            beginAtZero: true,
                                            title: {
                                                display: true,
                                                text: 'Cantidad de Préstamos',
                                                color: '#555',
                                                font: {
                                                    size: 13,
                                                    weight: 'bold'
                                                }
                                            },
                                            ticks: {
                                                stepSize: 1,
                                                precision: 0
                                            },
                                            grid: {
                                                color: 'rgba(0, 0, 0, 0.05)'
                                            }
                                        },
                                        x: {
                                            title: {
                                                display: true,
                                                text: 'Meses del Año',
                                                color: '#555',
                                                font: {
                                                    size: 13,
                                                    weight: 'bold'
                                                }
                                            },
                                            grid: {
                                                display: false
                                            }
                                        }
                                    },
                                    interaction: {
                                        mode: 'nearest',
                                        intersect: true
                                    },
                                    animation: {
                                        duration: 1000,
                                        easing: 'easeOutQuart'
                                    }
                                }
                            });
                        });
                    </script>
                </div>
                <div class="Principal-Right">
                    <div class="Principal-Arriba">
                        <h2>Reportes</h2>
                       <a href="{{ asset('reportes') }}"><i class="fa fa-home"></i>&nbsp;<img
                            src="{{ asset('Imagenes/Reportes.png') }}" alt="inicio"></a>
                    </div>

                    <div class="Principal-Abajo">
                        <h2>Uso de Salas Móviles</h2>
                        <div class="chart-container" style="position: relative; height:300px; width:100%">
                            <canvas id="graficaDonutSalasMoviles"></canvas>
                        </div>
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const salasMoviles = @json($usoSalasMoviles->pluck('SalaMovil'));
                                const usosSalas = @json($usoSalasMoviles->pluck('total'));
                                
                                const ctxDonut = document.getElementById('graficaDonutSalasMoviles').getContext('2d');
                                
                                function generarColoresDonut(cantidad) {
                                    const colores = [];
                                    const hueStep = 360 / cantidad;
                                    
                                    for (let i = 0; i < cantidad; i++) {
                                        const hue = Math.round((i * hueStep) % 360);
                                        colores.push(
                                            `hsla(${hue}, 80%, 60%, 0.7)`,
                                            `hsla(${hue}, 80%, 45%, 0.9)`
                                        );
                                    }
                                    return colores;
                                }
                                
                                const coloresDonut = generarColoresDonut(salasMoviles.length);
                                
                                new Chart(ctxDonut, {
                                    type: 'doughnut',
                                    data: {
                                        labels: salasMoviles,
                                        datasets: [{
                                            data: usosSalas,
                                            backgroundColor: coloresDonut,
                                            borderColor: 'rgba(255, 255, 255, 0.8)',
                                            borderWidth: 2,
                                            hoverOffset: 10
                                        }]
                                    },
                                    options: {
                                        responsive: true,
                                        maintainAspectRatio: false,
                                        cutout: '65%',
                                        plugins: {
                                            legend: {
                                                position: 'right',
                                                labels: {
                                                    padding: 20,
                                                    font: {
                                                        size: 12
                                                    },
                                                    usePointStyle: true,
                                                    pointStyle: 'circle'
                                                }
                                            },
                                            tooltip: {
                                                callbacks: {
                                                    label: function(context) {
                                                        const label = context.label || '';
                                                        const value = context.raw || 0;
                                                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                                        const percentage = Math.round((value / total) * 100);
                                                        return `${label}: ${value} (${percentage}%)`;
                                                    }
                                                }
                                            }
                                        },
                                        animation: {
                                            animateScale: true,
                                            animateRotate: true
                                        }
                                    }
                                });
                            });
                        </script>
                    </div>
                </div>
            </div>

            <footer>
                <p>Sistema de Préstamos de Portátiles © {{ date('Y') }}</p>
            </footer>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuToggle = document.getElementById('menuToggle');
            const navMenu = document.getElementById('navMenu');

            menuToggle.addEventListener('click', function() {
                this.classList.toggle('active');
                navMenu.classList.toggle('active');
                document.body.classList.toggle('menu-open');
            });

            // Cerrar menú al hacer clic en un enlace (solo en móviles)
            document.querySelectorAll('#navMenu a').forEach(link => {
                link.addEventListener('click', function() {
                    if (window.innerWidth <= 768) {
                        menuToggle.classList.remove('active');
                        navMenu.classList.remove('active');
                        document.body.classList.remove('menu-open');
                    }
                });
            });

            // Ajustar al cambiar tamaño de pantalla
            window.addEventListener('resize', function() {
                if (window.innerWidth > 768) {
                    menuToggle.classList.remove('active');
                    navMenu.classList.remove('active');
                    document.body.classList.remove('menu-open');
                }
            });
        });
    </script>
</body>

</html>