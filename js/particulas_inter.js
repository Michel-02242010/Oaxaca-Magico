class PointerParticle {
  constructor(spread, speed, component) {
    const { ctx, pointer } = component;

    this.ctx = ctx;
    this.x = pointer.x;
    this.y = pointer.y;
    this.mx = pointer.mx * 0.1;
    this.my = pointer.my * 0.1;
    this.size = Math.random() * 3 + 1;
    this.decay = 0.015;
    this.speed = speed * 0.08;
    this.spread = spread * this.speed;
    this.spreadX = (Math.random() - 0.5) * this.spread;
    this.spreadY = (Math.random() - 0.5) * this.spread ;

    // Tus tonos mágicos de Oaxaca (Dorados, Ámbar y Crema)
    const coloresOaxaca = [
      "hsl(36deg, 90%, 70%)",
      "hsl(36deg, 74%, 57%)",
      "hsl(21deg, 85%, 45%)"
    ];
    this.color = coloresOaxaca[Math.floor(Math.random() * coloresOaxaca.length)];
  }

  draw() {
    this.ctx.fillStyle = this.color;
    this.ctx.beginPath();
    this.ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
    this.ctx.fill();
  }

  collapse() {
    this.size -= this.decay;
  }

  trail() {
    this.x += this.spreadX * this.size;
    this.y += this.spreadY * this.size;
  }

  update() {
    this.draw();
    this.trail();
    this.collapse();
  }
}

class PointerParticles extends HTMLElement {
  static register(tag = "pointer-particles") {
    if ("customElements" in window) {
      customElements.define(tag, this);
    }
  }

   static css = `
    :host {
      display: grid;
      width: 100%;
      height: 100%;
      pointer-events: none;
      z-index: 999999 !important;
    }
  `;

  constructor() {
    super();
    this.canvas;
    this.ctx;
    this.fps = 60;
    this.msPerFrame = 1000 / this.fps;
    this.timePrevious;
    this.particles = [];
    this.pointer = { x: 0, y: 0, mx: 0, my: 0 };
  }

  connectedCallback() {
    const canvas = document.createElement("canvas");
    const sheet = new CSSStyleSheet();

    this.shadowroot = this.attachShadow({ mode: "open" });
    sheet.replaceSync(PointerParticles.css);
    this.shadowroot.adoptedStyleSheets = [sheet];
    this.shadowroot.append(canvas);

    this.canvas = this.shadowroot.querySelector("canvas");
    this.ctx = this.canvas.getContext("2d");
    this.setCanvasDimensions();
    this.setupEvents();
    this.timePrevious = performance.now();
    this.animateParticles();
  }

  createParticles(event, { count, speed, spread }) {
    this.setPointerValues(event);
    for (let i = 0; i < count; i++) {
      this.particles.push(new PointerParticle(spread, speed, this));
    }
  }

  setPointerValues(event) {
    this.pointer.x = event.clientX;
    this.pointer.y = event.clientY;
    this.pointer.mx = event.movementX;
    this.pointer.my = event.movementY;
  }

  setupEvents() {
    // Escucha los movimientos en toda la ventana para que sigan al cursor siempre
    window.addEventListener("click", (event) => {
      this.createParticles(event, {
        count: 80,
        speed: Math.random() + 1,
        spread: Math.random() + 25
      });
    });

    window.addEventListener("pointermove", (event) => {
      this.createParticles(event, {
        count: 3,
        speed: this.getPointerVelocity(event),
        spread: 1
      });
    });

    window.addEventListener("resize", () => this.setCanvasDimensions());
  }

  getPointerVelocity(event) {
    const a = event.movementX;
    const b = event.movementY;
    return Math.floor(Math.sqrt(a * a + b * b));
  }

  handleParticles() {
    for (let i = 0; i < this.particles.length; i++) {
      this.particles[i].update();
      if (this.particles[i].size <= 0.1) {
        this.particles.splice(i, 1);
        i--;
      }
    }
  }

  setCanvasDimensions() {
    this.canvas.width = window.screen.width;
    this.canvas.height = window.screen.height;
  }

  animateParticles() {
    requestAnimationFrame(() => this.animateParticles());
    const timeNow = performance.now();
    const timePassed = timeNow - this.timePrevious;

    if (timePassed < this.msPerFrame) return;

    const excessTime = timePassed % this.msPerFrame;
    this.timePrevious = timeNow - excessTime;

    this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);
    this.handleParticles();
  }
}

PointerParticles.register();