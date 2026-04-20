<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistema de Gestión Electoral</title>
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Figtree', sans-serif; height:100vh; overflow:hidden; display:flex; }

        .carousel {
            position:fixed; top:0; left:0; width:100%; height:100%;
            z-index:0;
        }
        .carousel-slide {
            position:absolute; top:0; left:0; width:100%; height:100%;
            background-size:cover; background-position:center;
            opacity:0; transition:opacity 1.2s ease-in-out;
        }
        .carousel-slide.active { opacity:1; }
        .carousel-slide::after {
            content:''; position:absolute; inset:0;
            background:linear-gradient(to right, rgba(10,25,50,0.75) 0%, rgba(10,25,50,0.4) 100%);
        }

        .login-side {
            position:relative; z-index:10;
            width:420px; min-width:420px; height:100vh;
            background:rgba(255,255,255,0.97);
            display:flex; flex-direction:column; justify-content:center;
            padding:48px 44px;
            box-shadow:4px 0 32px rgba(0,0,0,0.15);
        }

        .logo-wrap { text-align:center; margin-bottom:32px; }
        .logo-wrap img { width:90px; }
        .logo-wrap h1 { font-size:15px; font-weight:600; color:#1e3a5f; margin-top:12px; line-height:1.4; }
        .logo-wrap p { font-size:12px; color:#6b7280; margin-top:4px; }

        .form-group { margin-bottom:18px; }
        .form-group label { display:block; font-size:11px; font-weight:600; color:#6b7280; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:6px; }
        .form-group input { width:100%; border:1px solid #e5e7eb; border-radius:8px; padding:10px 14px; font-size:13px; color:#111827; outline:none; transition:border 0.2s; font-family:'Figtree',sans-serif; }
        .form-group input:focus { border-color:#1e3a5f; }

        .aviso-mayus { display:none; margin-top:6px; background:#fef9c3; color:#854d0e; font-size:11px; padding:4px 10px; border-radius:6px; }

        .remember-row { display:flex; align-items:center; justify-content:space-between; margin-bottom:24px; }
        .remember-row label { display:flex; align-items:center; gap:8px; font-size:13px; color:#6b7280; cursor:pointer; }
        .remember-row input[type=checkbox] { width:14px; height:14px; accent-color:#1e3a5f; }
        .remember-row a { font-size:12px; color:#1e3a5f; text-decoration:none; }
        .remember-row a:hover { text-decoration:underline; }

        .btn-login { width:100%; padding:12px; background:#1e3a5f; color:#fff; border:none; border-radius:8px; font-size:14px; font-weight:600; cursor:pointer; letter-spacing:0.3px; font-family:'Figtree',sans-serif; transition:background 0.2s; }
        .btn-login:hover { background:#16304f; }

        .error-msg { color:#dc2626; font-size:11px; margin-top:4px; }

        .footer-text { text-align:center; font-size:11px; color:#9ca3af; margin-top:32px; line-height:1.6; }

        .right-side {
            flex:1; position:relative; z-index:5;
            display:flex; align-items:flex-end; padding:48px;
        }
        .right-text { color:#fff; }
        .right-text h2 { font-size:28px; font-weight:600; line-height:1.3; margin-bottom:8px; }
        .right-text p { font-size:14px; opacity:0.75; }

        .dots { display:flex; gap:8px; margin-top:20px; }
        .dot { width:8px; height:8px; border-radius:50%; background:rgba(255,255,255,0.4); cursor:pointer; transition:background 0.3s; }
        .dot.active { background:#fff; }
    </style>
</head>
<body>

<div class="carousel">
    <div class="carousel-slide active" style="background-image:url('/images/login1b.jpeg')"></div>
    <div class="carousel-slide" style="background-image:url('/images/login2.jpeg')"></div>
    <div class="carousel-slide" style="background-image:url('/images/login3.jpeg')"></div>
</div>

<div class="login-side">
    <div class="logo-wrap">
        <img src="/images/logo.png" alt="TSJE">
        <h1>Dirección de Organizaciones<br>Intermedias</h1>
        <p>Tribunal Superior de Justicia Electoral</p>
    </div>

    <?php if (isset($component)) { $__componentOriginal7c1bf3a9346f208f66ee83b06b607fb5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal7c1bf3a9346f208f66ee83b06b607fb5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.auth-session-status','data' => ['class' => 'mb-4','status' => session('status')]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('auth-session-status'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mb-4','status' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(session('status'))]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal7c1bf3a9346f208f66ee83b06b607fb5)): ?>
<?php $attributes = $__attributesOriginal7c1bf3a9346f208f66ee83b06b607fb5; ?>
<?php unset($__attributesOriginal7c1bf3a9346f208f66ee83b06b607fb5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal7c1bf3a9346f208f66ee83b06b607fb5)): ?>
<?php $component = $__componentOriginal7c1bf3a9346f208f66ee83b06b607fb5; ?>
<?php unset($__componentOriginal7c1bf3a9346f208f66ee83b06b607fb5); ?>
<?php endif; ?>

    <form method="POST" action="<?php echo e(route('login')); ?>">
        <?php echo csrf_field(); ?>

        <div class="form-group">
            <label for="email">Correo electrónico</label>
            <input type="email" id="email" name="email" value="<?php echo e(old('email')); ?>" required autofocus autocomplete="username" placeholder="usuario@tsje.gov.py">
            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="error-msg"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="form-group">
            <label for="password">Contraseña</label>
            <input type="password" id="password" name="password" required autocomplete="current-password" placeholder="••••••••">
            <div class="aviso-mayus" id="aviso-mayus">⚠️ Bloq Mayús activado</div>
            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="error-msg"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="remember-row">
            <label>
                <input type="checkbox" name="remember" id="remember_me">
                Recordarme
            </label>
            <?php if(Route::has('password.request')): ?>
            <a href="<?php echo e(route('password.request')); ?>">¿Olvidaste tu contraseña?</a>
            <?php endif; ?>
        </div>

        <button type="submit" class="btn-login">Iniciar sesión</button>
    </form>

    <p class="footer-text">República del Paraguay &mdash; TSJE<br>Sistema de Gestión Electoral</p>
</div>

<div class="right-side">
    <div class="right-text">
        <h2>Sistema de Gestión<br>Electoral</h2>
        <p>Dirección de Organizaciones Intermedias</p>
        <div class="dots">
            <div class="dot active" onclick="goTo(0)"></div>
            <div class="dot" onclick="goTo(1)"></div>
            <div class="dot" onclick="goTo(2)"></div>
        </div>
    </div>
</div>

<script>
const passInput = document.getElementById('password');
const avisoMayus = document.getElementById('aviso-mayus');
passInput.addEventListener('keyup', e => avisoMayus.style.display = e.getModifierState('CapsLock') ? 'block' : 'none');
passInput.addEventListener('keydown', e => avisoMayus.style.display = e.getModifierState('CapsLock') ? 'block' : 'none');

const slides = document.querySelectorAll('.carousel-slide');
const dots = document.querySelectorAll('.dot');
let current = 0;

function goTo(n) {
    slides[current].classList.remove('active');
    dots[current].classList.remove('active');
    current = n;
    slides[current].classList.add('active');
    dots[current].classList.add('active');
}

setInterval(() => goTo((current + 1) % slides.length), 5000);
</script>

</body>
</html>
<?php /**PATH /var/www/html/resources/views/auth/login.blade.php ENDPATH**/ ?>