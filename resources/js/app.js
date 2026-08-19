import './bootstrap';

// Alpine.js ya no se importa acá manualmente: Livewire (@livewireScripts)
// trae y arranca su propia instancia de Alpine. Tener las dos causaba el
// warning "Detected multiple instances of Alpine running" y rompía la
// sincronización reactiva de los componentes Livewire (ej. papeletas/materiales).
