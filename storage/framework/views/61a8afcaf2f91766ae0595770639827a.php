<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="Ymj0MJz7GLuWEEHwa2fv4eV65gzIk9SqMMCXHtU9">
    <title>Laravel</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link rel="icon" type="image/x-icon" href="/favicon-tsje.ico">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="preload" as="style" href="http://localhost/build/assets/app-UnhBRrx2.css" /><link rel="modulepreload" as="script" href="http://localhost/build/assets/app-CRifDVQk.js" /><link rel="stylesheet" href="http://localhost/build/assets/app-UnhBRrx2.css" /><script type="module" src="http://localhost/build/assets/app-CRifDVQk.js"></script>    <style>
    @keyframes humo {
        0%   { background-position: 0% 50%; }
        50%  { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }
    * { scrollbar-width: none; -ms-overflow-style: none; }
    *::-webkit-scrollbar { display: none; }
    #ticker-nombre, #ticker-dias { transition: opacity 0.3s ease; }
    </style>
</head>

<body class="font-sans antialiased" style="min-height:100vh; overflow:hidden; height:100vh;">


<div style="position:fixed; top:0; left:0; width:100%; height:100%; z-index:-1;
    background: linear-gradient(135deg, #f0f2f5 0%, #e2e8f8 35%, #ede8f5 65%, #f0f2f5 100%);
    background-size: 400% 400%;
    animation: humo 10s ease infinite;">
</div>

<div style="display:flex; height:100vh; background:transparent; overflow:hidden;">

    
    <div style="width:220px; min-width:220px; background:linear-gradient(180deg, rgba(30,50,160,0.75) 0%, rgba(20,35,120,0.85) 50%, rgba(30,50,160,0.75) 100%); display:flex; flex-direction:column; backdrop-filter:blur(16px); -webkit-backdrop-filter:blur(16px); border-right:1px solid rgba(255,255,255,0.12); box-shadow:2px 0 16px rgba(43,78,200,0.15);">

        
        <div style="padding:20px 16px 16px; border-bottom:1px solid rgba(255,255,255,0.07);">
            <div style="font-size:14px; font-weight:600; color:#fff; letter-spacing:0.3px;">Dir. Org. Intermedias</div>
            <div style="font-size:11px; color:rgba(255,255,255,0.35); margin-top:2px;">Sistema de Gestion</div>
        </div>

        
        <div style="margin:14px 12px 6px; padding:9px 12px; background:rgba(255,255,255,0.06); border-radius:8px; border:1px solid rgba(255,255,255,0.08);">
            <div style="font-size:10px; color:rgba(255,255,255,0.35); margin-bottom:2px;">Rol activo</div>
            <div style="font-size:13px; font-weight:500; color:#fff;">Asesor</div>
        </div>

        
        <div style="padding:14px 14px 4px; font-size:10px; color:rgba(255,255,255,0.25); letter-spacing:1px; text-transform:uppercase;">Principal</div>
        <a href="http://localhost/panel/dashboard"
            style="display:flex; align-items:center; gap:10px; padding:9px 14px; margin:1px 8px; border-radius:8px; font-size:13px; color:#fff; background:rgba(99,130,255,0.2); text-decoration:none; border:1px solid rgba(99,130,255,0.3); transition:all 0.2s;"
            onmouseover="this.style.background='rgba(255,255,255,0.12)'"
            onmouseout="this.style.background='rgba(99,130,255,0.2)'">
            <span style="width:7px; height:7px; border-radius:50%; background:#60a5fa; flex-shrink:0;"></span>
            Panel General
        </a>

        
        <div style="padding:14px 14px 4px; font-size:10px; color:rgba(255,255,255,0.25); letter-spacing:1px; text-transform:uppercase;">Entradas</div>
        <a href="http://localhost/secretaria/con-nota"
            style="display:flex; align-items:center; gap:10px; padding:9px 14px; margin:1px 8px; border-radius:8px; font-size:13px; color:rgba(255,255,255,0.55); background:transparent; text-decoration:none; border:1px solid transparent; transition:all 0.2s;"
            onmouseover="this.style.background='rgba(255,255,255,0.12)'"
            onmouseout="this.style.background='transparent'">
            <span style="width:7px; height:7px; border-radius:50%; background:#34d399; flex-shrink:0;"></span>
            Mesa de Entrada
        </a>
        <a href="http://localhost/asesor/mis-organizaciones"
    style="display:flex; align-items:center; gap:10px; padding:9px 14px; margin:1px 8px; border-radius:8px; font-size:13px; color:rgba(255,255,255,0.55); background:transparent; text-decoration:none; border:1px solid transparent; transition:all 0.2s;"
    onmouseover="this.style.background='rgba(255,255,255,0.12)'"
    onmouseout="this.style.background='transparent'">
    <span style="width:7px; height:7px; border-radius:50%; background:rgba(255,255,255,0.28); flex-shrink:0;"></span>
    Mis organizaciones
</a>
        </a>

        
        <div style="padding:14px 14px 4px; font-size:10px; color:rgba(255,255,255,0.25); letter-spacing:1px; text-transform:uppercase;">Trabajo</div>
        <a href="#"
            style="display:flex; align-items:center; gap:10px; padding:9px 14px; margin:1px 8px; border-radius:8px; font-size:13px; color:rgba(255,255,255,0.55); text-decoration:none; border:1px solid transparent; transition:all 0.2s;"
            onmouseover="this.style.background='rgba(255,255,255,0.12)'"
            onmouseout="this.style.background='transparent'">
            <span style="width:7px; height:7px; border-radius:50%; background:#fbbf24; flex-shrink:0;"></span>
            Panel tecnico
        </a>
        <a href="#"
            style="display:flex; align-items:center; gap:10px; padding:9px 14px; margin:1px 8px; border-radius:8px; font-size:13px; color:rgba(255,255,255,0.55); text-decoration:none; border:1px solid transparent; transition:all 0.2s;"
            onmouseover="this.style.background='rgba(255,255,255,0.12)'"
            onmouseout="this.style.background='transparent'">
            <span style="width:7px; height:7px; border-radius:50%; background:#a78bfa; flex-shrink:0;"></span>
            Charlas
        </a>
        <a href="#"
            style="display:flex; align-items:center; gap:10px; padding:9px 14px; margin:1px 8px; border-radius:8px; font-size:13px; color:rgba(255,255,255,0.55); text-decoration:none; border:1px solid transparent; transition:all 0.2s;"
            onmouseover="this.style.background='rgba(255,255,255,0.12)'"
            onmouseout="this.style.background='transparent'">
            <span style="width:7px; height:7px; border-radius:50%; background:#f472b6; flex-shrink:0;"></span>
            Borrador privado
        </a>

        
        <div style="padding:14px 14px 4px; font-size:10px; color:rgba(255,255,255,0.25); letter-spacing:1px; text-transform:uppercase;">Utilidades</div>
        <a href="#"
            style="display:flex; align-items:center; gap:10px; padding:9px 14px; margin:1px 8px; border-radius:8px; font-size:13px; color:rgba(255,255,255,0.55); text-decoration:none; border:1px solid transparent; transition:all 0.2s;"
            onmouseover="this.style.background='rgba(255,255,255,0.12)'"
            onmouseout="this.style.background='transparent'">
            <span style="width:7px; height:7px; border-radius:50%; background:rgba(255,255,255,0.28); flex-shrink:0;"></span>
            Manuales
        </a>

    </div>
    

    
    <div style="flex:1; display:flex; flex-direction:column; overflow:hidden; background:transparent;">

        
        <div style="background:rgba(255,255,255,0.4); backdrop-filter:blur(8px); border-bottom:1px solid #e5e7eb; padding:13px 22px; display:flex; align-items:center; justify-content:space-between;">

            
            <div style="display:flex; align-items:center; gap:8px;">
                <svg width="16" height="16" fill="none" stroke="#6b7280" stroke-width="1.8" viewBox="0 0 24 24">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                </svg>
                <span style="font-size:15px; font-weight:500; color:#111827;">Panel General</span>
            </div>

            
            <div style="display:flex; align-items:center; gap:14px;">

               
                                                                <div onclick="toggleElecciones()" id="ticker-box"
                     style="display:flex; align-items:center; gap:8px; background:#f0f9ff; border:1px solid #bae6fd; border-radius:8px; padding:5px 12px; cursor:pointer; min-width:180px; max-width:260px;">
                    <svg width="13" height="13" fill="none" stroke="#0369a1" stroke-width="1.8" viewBox="0 0 24 24" style="flex-shrink:0;">
                        <rect x="3" y="4" width="18" height="18" rx="2"/>
                        <line x1="16" y1="2" x2="16" y2="6"/>
                        <line x1="8" y1="2" x2="8" y2="6"/>
                        <line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                    <span style="font-size:11px; color:#0369a1; font-weight:600; white-space:nowrap; flex-shrink:0;">Próxima:</span>
                    <span id="ticker-nombre" style="font-size:12px; color:#0c4a6e; font-weight:500; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; flex:1;">COLEGIO STELLA MARYS</span>
                    <span id="ticker-dias" style="font-size:10px; font-weight:600; padding:2px 7px; border-radius:20px; flex-shrink:0;
                        background:#fee2e2;
                        color:#991b1b;">
                        4 días
                    </span>
                </div>
                                
                
                
                
                <div style="position:relative; cursor:pointer;" onclick="toggleNotif()">
                    <svg width="20" height="20" fill="none" stroke="#6b7280" stroke-width="1.5" viewBox="0 0 24 24">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                        <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                    </svg>
                                                        </div>

                
                <div onclick="toggleMenu()" style="width:32px; height:32px; border-radius:50%; background:#185FA5; display:flex; align-items:center; justify-content:center; font-size:11px; font-weight:600; color:#fff; cursor:pointer; user-select:none;">
                    SA
                </div>

            </div>
        </div>
        

        
       <div style="flex:1; padding:10px 8px 60px 8px; overflow-y:auto; overflow-x:hidden; background:transparent;">
    <div style="position:relative; top:0; z-index:10; margin:-18px -18px 0 -18px; padding:18px 18px 0 18px; background:linear-gradient(135deg, #e8f0f5 0%, #dde8f0 25%, #e5edf5 50%, #dde8f0 75%, #e8f0f5 100%); box-shadow:0 8px 20px rgba(180,180,190,0.3);">
<div style="max-width:1000px; margin:0 auto;">

    
    <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:14px; margin-bottom:14px;">

        
        <div style="background:linear-gradient(135deg,#E8834A,#F5A623); border-radius:14px; padding:18px 20px; position:relative; overflow:hidden; box-shadow:0 4px 12px rgba(232,131,74,0.35);">
            <div style="position:absolute;top:14px;right:16px;opacity:0.55;">
                <svg width="36" height="36" fill="none" stroke="#fff" stroke-width="1.5" viewBox="0 0 24 24">
                    <path d="M3 21h18M3 10h18M5 6l7-3 7 3M4 10v11M20 10v11M8 14v3M12 14v3M16 14v3"/>
                </svg>
            </div>
            <div style="font-size:11px; color:rgba(255,255,255,0.85); margin-bottom:6px; font-weight:500;">Mis organizaciones</div>
            <div style="font-size:36px; font-weight:700; color:#fff; line-height:1;">3</div>
            <span style="display:inline-flex; background:rgba(255,255,255,0.22); border-radius:20px; padding:3px 10px; font-size:10px; color:#fff; margin-top:10px;">asignadas</span>
        </div>

        
        <div style="background:linear-gradient(135deg,#4A7C59,#6BAF7A); border-radius:14px; padding:18px 20px; position:relative; overflow:hidden; box-shadow:0 4px 12px rgba(74,124,89,0.35);">
            <div style="position:absolute;top:14px;right:16px;opacity:0.55;">
                <svg width="36" height="36" fill="none" stroke="#fff" stroke-width="1.5" viewBox="0 0 24 24">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                    <polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
            </div>
            <div style="font-size:11px; color:rgba(255,255,255,0.85); margin-bottom:6px; font-weight:500;">Charlas realizadas</div>
            <div style="font-size:36px; font-weight:700; color:#fff; line-height:1;">0</div>
            <span style="display:inline-flex; background:rgba(255,255,255,0.22); border-radius:20px; padding:3px 10px; font-size:10px; color:#fff; margin-top:10px;">este mes</span>
        </div>

        
        <div style="background:linear-gradient(135deg,#5B9EC9,#7BBDE0);; border-radius:14px; padding:18px 20px; position:relative; overflow:hidden; box-shadow:0 4px 12px rgba(196,112,74,0.35);">
            <div style="position:absolute;top:14px;right:16px;opacity:0.55;">
                <svg width="36" height="36" fill="none" stroke="#fff" stroke-width="1.5" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10"/>
                    <polyline points="12 6 12 12 16 14"/>
                </svg>
            </div>
            <div style="font-size:11px; color:rgba(255,255,255,0.85); margin-bottom:6px; font-weight:500;">Charlas pendientes</div>
            <div style="font-size:36px; font-weight:700; color:#fff; line-height:1;">2</div>
            <span style="display:inline-flex; background:rgba(255,255,255,0.22); border-radius:20px; padding:3px 10px; font-size:10px; color:#fff; margin-top:10px;">sin realizar</span>
        </div>

        
        <div style="background:linear-gradient(135deg,#7A8A95,#9BAAB5); border-radius:14px; padding:18px 20px; position:relative; overflow:hidden; box-shadow:0 4px 12px rgba(46,107,138,0.35);">
            <div style="position:absolute;top:14px;right:16px;opacity:0.55;">
                <svg width="36" height="36" fill="none" stroke="#fff" stroke-width="1.5" viewBox="0 0 24 24">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                    <line x1="16" y1="13" x2="8" y2="13"/>
                    <line x1="16" y1="17" x2="8" y2="17"/>
                    <polyline points="10 9 9 9 8 9"/>
                </svg>
            </div>
            <div style="font-size:11px; color:rgba(255,255,255,0.85); margin-bottom:6px; font-weight:500;">Borrador privado</div>
            <div style="font-size:36px; font-weight:700; color:#fff; line-height:1;">0</div>
            <span style="display:inline-flex; background:rgba(255,255,255,0.22); border-radius:20px; padding:3px 10px; font-size:10px; color:#fff; margin-top:10px;">mis borradores</span>
        </div>

        
        <div style="background:linear-gradient(135deg,#8A6B2E,#B59040); border-radius:14px; padding:18px 20px; position:relative; overflow:hidden; box-shadow:0 4px 12px rgba(138,107,46,0.35);">
            <div style="position:absolute;top:14px;right:16px;opacity:0.55;">
                <svg width="36" height="36" fill="none" stroke="#fff" stroke-width="1.5" viewBox="0 0 24 24">
                    <rect x="3" y="4" width="18" height="18" rx="2"/>
                    <line x1="16" y1="2" x2="16" y2="6"/>
                    <line x1="8" y1="2" x2="8" y2="6"/>
                    <line x1="3" y1="10" x2="21" y2="10"/>
                    <line x1="9" y1="15" x2="15" y2="15"/>
                </svg>
            </div>
            <div style="font-size:11px; color:rgba(255,255,255,0.85); margin-bottom:6px; font-weight:500;">Sin fecha de elección</div>
            <div style="font-size:36px; font-weight:700; color:#fff; line-height:1;">0</div>
            <span style="display:inline-flex; background:rgba(255,255,255,0.22); border-radius:20px; padding:3px 10px; font-size:10px; color:#fff; margin-top:10px;">requieren fecha</span>
        </div>

        
        <div style="background:linear-gradient(135deg,#C8A020,#E0BC40); border-radius:14px; padding:18px 20px; position:relative; overflow:hidden; box-shadow:0 4px 12px rgba(122,74,46,0.35);">
            <div style="position:absolute;top:14px;right:16px;opacity:0.55;">
                <svg width="36" height="36" fill="none" stroke="#fff" stroke-width="1.5" viewBox="0 0 24 24">
                    <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/>
                </svg>
            </div>
            <div style="font-size:11px; color:rgba(255,255,255,0.85); margin-bottom:6px; font-weight:500;">Trabajo técnico pendiente</div>
            <div style="font-size:36px; font-weight:700; color:#fff; line-height:1;">1</div>
            <span style="display:inline-flex; background:rgba(255,255,255,0.22); border-radius:20px; padding:3px 10px; font-size:10px; color:#fff; margin-top:10px;">por resolver</span>
        </div>

    </div>

    
    <div style="background:rgba(255,255,255,0.95); border-radius:16px 16px 0 0; border:1px solid rgba(255,255,255,0.9); border-bottom:none;">
        <div style="padding:6px 16px; border-bottom:1px solid #e5e7eb; font-size:13px; font-weight:500; color:#111827; display:flex; justify-content:space-between; align-items:center;">
            Mis organizaciones
<a href="http://localhost/asesor/mis-organizaciones" style="font-size:12px; color:#1f0566; text-decoration:none;">Ver todas</a>        </div>
        <table style="width:100%; border-collapse:collapse;">
            <thead>
                <tr style="background:rgba(100,150,200,0.2);">
                    <th style="padding:5px 10px; text-align:left; color:#fff; font-weight:500; font-size:12px; width:120px;">Codigo</th>
                    <th style="padding:5px 10px; text-align:left; color:#fff; font-weight:500; font-size:12px;">Organizacion</th>
                    <th style="padding:5px 1px; text-align:left; color:#fff; font-weight:500; font-size:12px; width:100px;">Asunto</th>
                    <th style="padding:5px 4px; text-align:left; color:#fff; font-weight:500; font-size:12px; width:120px;">Estado</th>
                </tr>
            </thead>
        </table>
    </div>

</div>
</div>



<div style="max-width:1000px; margin:0 auto;">

<div style="background:rgba(255,255,255,0.75); backdrop-filter:blur(12px); -webkit-backdrop-filter:blur(12px); border:1px solid rgba(255,255,255,0.9); border-top:none; border-radius:0 0 16px 16px; box-shadow:0 20px 60px rgba(240, 240, 241, 0.15), 0 8px 20px rgba(234, 234, 241, 0.1); margin-bottom:40px;">
    <table style="width:100%; border-collapse:collapse; font-size:11px;">
        <tbody>
                        <tr style="border-bottom:1px solid #f3f4f6;" onmouseover="this.style.background='rgba(232,131,74,0.06)'" onmouseout="this.style.background='transparent'">
                <td style="padding:5px 10px; color:#E8834A; font-weight:600; font-family:monospace; width:120px;">ORG-2026-0040</td>
                <td style="padding:5px 10px; color:#111827;">CLUB SAN FERNANDO</td>
                <td style="padding:5px 1px; color:#111827; font-weight:600; width:100px;">Char</td>
                <td style="padding:5px 2px; width:120px;">
                                                                    <span style="display:inline-flex; align-items:center; gap:3px; margin-right:6px;">
                            <span style="font-size:11px; color:#6b7280;">Char</span>
                            <span style="width:9px; height:9px; border-radius:50%; background:#eab308; display:inline-block;"></span>
                        </span>
                                                                            </td>
            </tr>
                        <tr style="border-bottom:1px solid #f3f4f6;" onmouseover="this.style.background='rgba(232,131,74,0.06)'" onmouseout="this.style.background='transparent'">
                <td style="padding:5px 10px; color:#E8834A; font-weight:600; font-family:monospace; width:120px;">ORG-2026-0014</td>
                <td style="padding:5px 10px; color:#111827;">JUNTA DE SANEAMIENTO CAAGUAZU</td>
                <td style="padding:5px 1px; color:#111827; font-weight:600; width:100px;">Log</td>
                <td style="padding:5px 2px; width:120px;">
                                                                                        <span style="display:inline-flex; align-items:center; gap:3px; margin-right:6px;">
                            <span style="font-size:11px; color:#6b7280;">Log</span>
                            <span style="width:9px; height:9px; border-radius:50%; background:#16a34a; display:inline-block;"></span>
                        </span>
                                                        </td>
            </tr>
                        <tr style="border-bottom:1px solid #f3f4f6;" onmouseover="this.style.background='rgba(232,131,74,0.06)'" onmouseout="this.style.background='transparent'">
                <td style="padding:5px 10px; color:#E8834A; font-weight:600; font-family:monospace; width:120px;">ORG-2026-0007</td>
                <td style="padding:5px 10px; color:#111827;">COLEGIO STELLA MARYS</td>
                <td style="padding:5px 1px; color:#111827; font-weight:600; width:100px;">Char · Tec</td>
                <td style="padding:5px 2px; width:120px;">
                                                                    <span style="display:inline-flex; align-items:center; gap:3px; margin-right:6px;">
                            <span style="font-size:11px; color:#6b7280;">Char</span>
                            <span style="width:9px; height:9px; border-radius:50%; background:#eab308; display:inline-block;"></span>
                        </span>
                                                                                                            <span style="display:inline-flex; align-items:center; gap:3px;">
                            <span style="font-size:11px; color:#6b7280;">Tec</span>
                            <span style="width:9px; height:9px; border-radius:50%; background:#eab308; display:inline-block;"></span>
                        </span>
                                    </td>
            </tr>
                    </tbody>
    </table>
</div>
</div>
</div>

    </div>
    

</div>


<div id="eleccionesMenu" style="display:none; position:fixed; top:52px; right:80px; background:#fff; border:1px solid #e5e7eb; border-radius:12px; box-shadow:0 8px 24px rgba(0,0,0,0.12); width:290px; z-index:99999; overflow:hidden;">
    <div style="padding:10px 14px; border-bottom:1px solid #f3f4f6;">
    <span style="font-size:11px; font-weight:600; color:#374151; text-transform:uppercase; letter-spacing:0.5px;">Elecciones próximas</span>
</div>
<div style="display:flex; justify-content:space-between; align-items:center; padding:9px 14px; border-bottom:1px solid #f9fafb;">
    <div>
        <div style="font-size:12px; font-weight:500; color:#111827;">COLEGIO STELLA MARYS</div>
        <div style="font-size:10.5px; color:#6b7280;">18 Apr 2026 — Santiago Acuña</div>
    </div>
    <span style="font-size:10.5px; font-weight:500; padding:3px 9px; border-radius:20px; flex-shrink:0;
        background:#fee2e2;
        color:#991b1b;">
        4 días
    </span>
</div>
    <div style="display:flex; justify-content:space-between; align-items:center; padding:9px 14px; border-bottom:1px solid #f9fafb;">
    <div>
        <div style="font-size:12px; font-weight:500; color:#111827;">CLUB SAN FERNANDO</div>
        <div style="font-size:10.5px; color:#6b7280;">30 Apr 2026 — Santiago Acuña</div>
    </div>
    <span style="font-size:10.5px; font-weight:500; padding:3px 9px; border-radius:20px; flex-shrink:0;
        background:#d1fae5;
        color:#065f46;">
        16 días
    </span>
</div>
        </div>




<div id="notifMenu" style="display:none; position:fixed; top:52px; right:60px; background:#fff; border:1px solid #e5e7eb; border-radius:12px; box-shadow:0 8px 24px rgba(0,0,0,0.12); width:300px; z-index:99999; overflow:hidden;">
    <div style="padding:12px 16px; border-bottom:1px solid #f3f4f6; display:flex; justify-content:space-between; align-items:center;">
        <span style="font-size:12px; font-weight:600; color:#374151; text-transform:uppercase; letter-spacing:0.5px;">Notificaciones</span>
            </div>
    <div style="max-height:320px; overflow:auto;">
                <div style="padding:20px 16px; text-align:center; font-size:12px; color:#9ca3af;">Sin notificaciones.</div>
            </div>
</div>


<div id="userMenu" style="display:none; position:fixed; top:52px; right:16px; background:#fff; border:1px solid #e5e7eb; border-radius:10px; box-shadow:0 8px 24px rgba(0,0,0,0.15); min-width:160px; z-index:99999; overflow:hidden;">
    <div style="padding:10px 14px; border-bottom:1px solid #f3f4f6;">
        <div style="font-size:12px; font-weight:500; color:#111827;">Santiago Acuña</div>
        <div style="font-size:11px; color:#9ca3af; margin-top:1px;">Asesor</div>
    </div>
    <a href="#" style="display:flex; align-items:center; gap:8px; padding:9px 14px; font-size:13px; color:#374151; text-decoration:none;"
        onmouseover="this.style.background='#f9fafb'"
        onmouseout="this.style.background='transparent'">
        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
            <circle cx="12" cy="7" r="4"/>
        </svg>
        Perfil
    </a>
    <form method="POST" action="http://localhost/logout">
        <input type="hidden" name="_token" value="Ymj0MJz7GLuWEEHwa2fv4eV65gzIk9SqMMCXHtU9" autocomplete="off">        <button type="submit" style="width:100%; display:flex; align-items:center; gap:8px; padding:9px 14px; font-size:13px; color:#e24b4a; background:transparent; border:none; cursor:pointer; text-align:left;"
            onmouseover="this.style.background='#fff5f5'"
            onmouseout="this.style.background='transparent'">
            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                <polyline points="16 17 21 12 16 7"/>
                <line x1="21" y1="12" x2="9" y2="12"/>
            </svg>
            Cerrar sesión
        </button>
    </form>
</div>

<script>
const tickerItems = [{"nombre":"COLEGIO STELLA MARYS","dias":4,"bg":"#fee2e2","color":"#991b1b"},{"nombre":"CLUB SAN FERNANDO","dias":16,"bg":"#d1fae5","color":"#065f46"}];
let tickerIdx = 0;
const tickerNombre = document.getElementById('ticker-nombre');
const tickerDias = document.getElementById('ticker-dias');
if (tickerNombre && tickerItems.length > 1) {
    setInterval(() => {
        tickerNombre.style.opacity = '0';
        tickerDias.style.opacity = '0';
        setTimeout(() => {
            tickerIdx = (tickerIdx + 1) % tickerItems.length;
            const item = tickerItems[tickerIdx];
            tickerNombre.textContent = item.nombre;
            tickerDias.textContent = item.dias + ' días';
            tickerDias.style.background = item.bg;
            tickerDias.style.color = item.color;
            tickerNombre.style.opacity = '1';
            tickerDias.style.opacity = '1';
        }, 300);
    }, 3000);
}

function closeAll() {
    document.getElementById('notifMenu').style.display = 'none';
    document.getElementById('userMenu').style.display = 'none';
    const el = document.getElementById('eleccionesMenu');
    if (el) el.style.display = 'none';
    const ch = document.getElementById('charlasMenu');
    if (ch) ch.style.display = 'none';
}

function toggleCharlas() {
    const ch = document.getElementById('charlasMenu');
    const visible = ch.style.display === 'block';
    closeAll();
    if (!visible) ch.style.display = 'block';
}

function toggleElecciones() {
    const el = document.getElementById('eleccionesMenu');
    const visible = el.style.display === 'block';
    closeAll();
    if (!visible) el.style.display = 'block';
}

function toggleNotif() {
    const notif = document.getElementById('notifMenu');
    const visible = notif.style.display === 'block';
    closeAll();
    if (!visible) notif.style.display = 'block';
}

function toggleMenu() {
    const menu = document.getElementById('userMenu');
    const visible = menu.style.display === 'block';
    closeAll();
    if (!visible) menu.style.display = 'block';
}

document.addEventListener('click', function(e) {
    if (!e.target.closest('#eleccionesMenu') && !e.target.closest('#ticker-box') &&
        !e.target.closest('#notifMenu') && !e.target.closest('[onclick="toggleNotif()"]') &&
        !e.target.closest('#userMenu') && !e.target.closest('[onclick="toggleMenu()"]')) {
        closeAll();
    }
});
</script>
</body>
</html>
<?php /**PATH /var/www/html/storage/framework/views/7bebbdf00968fcd665c5d5da18a76404.blade.php ENDPATH**/ ?>