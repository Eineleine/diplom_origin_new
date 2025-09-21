const halls = document.querySelectorAll('.conf-step__seances-hall');
const timelines = Array.from(halls).map(hall => {
  return {
    hall_id: hall.querySelector('.conf-step__seances-title').dataset.id,
    elem: hall.querySelector('.conf-step__seances-timeline'),
    rect: hall.querySelector('.conf-step__seances-timeline').getBoundingClientRect()
  }
});

class MovieDrop {
  constructor(elem) {
    this.elem = elem;
    elem.ondragstart = () => { return false };
    elem.addEventListener('mousedown', this.onMouseDown.bind(this));
    this.mouseMove = this.onMouseMove.bind(this);
    this.mouseUp = this.onMouseUp.bind(this);
  }

  static fromMovie(movie) {
    const title = movie.querySelector('.conf-step__movie-title').innerText;
    const duration = parseFloat(movie.querySelector('.conf-step__movie-duration').innerText);
    const color = window.getComputedStyle(movie).getPropertyValue('background-color');

    const elem = document.createElement('div');
    elem.ondragstart = () => { return false };
    elem.className = 'conf-step__seances-movie';
    elem.innerHTML = `<p class="conf-step__seances-movie-title">${title}</p><p class="conf-step__seances-movie-start"></p>`;
    elem.dataset.id = movie.dataset.id;
    elem.style.backgroundColor = color;
    elem.style.width = Math.ceil(duration / 2) + 'px';
    elem.style.zIndex = 99;

    document.body.appendChild(elem);
    return new MovieDrop(elem);
  }

  moveAt(pageX, pageY) {
    const left = pageX - this.elem.offsetWidth / 2;
    this.elem.style.left = left + 'px';
    this.elem.style.top = pageY - this.elem.offsetHeight / 2 + 'px';
    this.setStart(left);
  }

  onMouseDown(event) {
    if (!event.target.classList.contains('conf-step__movie-delete') && event.button === 0) {
      document.body.appendChild(this.elem);
      this.moveAt(event.pageX, event.pageY);
      document.addEventListener('mousemove', this.mouseMove);
      this.elem.addEventListener('mouseup', this.mouseUp);
    }
  }

  onMouseUp() {
    document.removeEventListener('mousemove', this.mouseMove);
    this.elem.removeEventListener('mouseup', this.mouseUp);
    this.handlePlacement();
  }

  onMouseMove(event) {
    this.moveAt(event.pageX, event.pageY);
  }

  handlePlacement() {
    for (let i = 0; i < timelines.length; i++) {
      if (collision(this.elem, timelines[i].elem)) {
        // Фильм пересекается со шкалой - коррекция выхода за границы и координат относительно шкалы
        const inTimeline = timelineBounds(timelines[i], this.elem);
        if (inTimeline === -1) {
          this.elem.style.left = '0';
        } else if (inTimeline === 1) {
          this.elem.style.left = timelines[i].rect.width - parseInt(this.elem.style.width) + 'px';
        } else {
          this.elem.style.left = parseInt(this.elem.style.left) - timelines[i].rect.left + 'px';
        }
        const neighbors = timelines[i].elem.querySelectorAll('.conf-step__seances-movie');
        timelines[i].elem.appendChild(this.elem);
        this.elem.style.top = null;
        // Фильм размещен на шкале, проверяем, нет ли наложений на другие фильмы
        let collisions = 0;
        let collidingElem = null;
        for (let j = 0; j < neighbors.length; j++) {
          if (collision(neighbors[j], this.elem)) {
            collisions++;
            if (collisions > 1) {
              // Промежуток слишком короткий, размещение невозможно.
              this.cannotPlace(true);
              return;
            }
            collidingElem = neighbors[j];
          }
        }
        if (collidingElem) {
          // Попытаться разрешить наложение автоматически
          this.elem.style.left = (sortCollision(collidingElem, this.elem) - timelines[i].rect.left) + 'px';
          if (timelineBounds(timelines[i], this.elem) !== 0) {
            this.cannotPlace(true);
            return;
          }
          for (let j = 0; j < neighbors.length; j++) {
            if (collision(neighbors[j], this.elem)) {
              this.cannotPlace(true);
              return;
            }
          }
        }
        this.setStart(this.elem.getBoundingClientRect().left);
        return;
      }
    }
    // Пересечений с залами нет - фильм "выброшен" из сетки
    this.cannotPlace(false);
    return;
  }

  cannotPlace(showMessage) {
    if (showMessage) {
      alert('Невозможно разместить фильм в этой части сетки.');
    }
    this.elem.remove();
  }

  setStart(startPixel) {
    const startPx = Math.floor(startPixel)
    if (startPx >= timelines[0].rect.left && startPx <= timelines[0].rect.right) {
      const relative = startPx - timelines[0].rect.left;
      const hour = Math.floor(relative / 30);
      const minute = Math.floor(relative % 30) * 2;
      const time = hour.toString().padStart(2, '0') + ':' + minute.toString().padStart(2, '0');
      this.elem.querySelector('.conf-step__seances-movie-start').innerText = time;
    }
  }
}

function collision(elem1, elem2) {
  var rect1 = elem1.getBoundingClientRect();
  var rect2 = elem2.getBoundingClientRect();

  return !(
    rect1.top > rect2.bottom ||
    rect1.right < rect2.left ||
    rect1.bottom < rect2.top ||
    rect1.left > rect2.right
  );
}

function sortCollision(obj, subj) {
  const rectObj = obj.getBoundingClientRect();
  const rectSubj = subj.getBoundingClientRect();
  const middleObj = rectObj.left + rectObj.width / 2;
  const middleSubj = rectSubj.left + rectSubj.width / 2;
  if (middleSubj < middleObj) {
    return rectObj.left - rectSubj.width - 0.1;
  }
  else {
    return rectObj.right + 0.1;
  }
}

function timelineBounds(timeline, movie) {
  var rect = movie.getBoundingClientRect();
  return (
    rect.left < timeline.rect.left
      ? -1
      : rect.right > timeline.rect.right
        ? 1
        : 0
  );
}

function initSeances() {
  const movieNodes = document.querySelectorAll('.conf-step__movie');
  movieNodes.forEach(movie => {
    movie.ondragstart = () => { return false };
    movie.onmousedown = (event) => {
      if (!event.target.classList.contains('conf-step__movie-delete') && event.button === 0) {
        const drop = MovieDrop.fromMovie(movie);
        drop.moveAt(event.pageX, event.pageY);
        drop.onMouseDown(event);
      }
    };
  });

  const movieData = Array.from(movieNodes).map(item => {
    const color = window.getComputedStyle(item).getPropertyValue('background-color');
    const title = item.querySelector('.conf-step__movie-title').innerText;
    return { title: title, color: color };
  });

  document.querySelectorAll('.conf-step__seances-movie').forEach(item => {
    const title = item.querySelector('.conf-step__seances-movie-title').innerText;
    const time = item.querySelector('.conf-step__seances-movie-start').innerText.split(':');
    const left = parseInt(time[0]) * 30 + parseInt(time[1]) / 2;
    const movie = movieData.find(item => item.title === title);
    item.style.backgroundColor = movie.color;
    item.style.left = left + 'px';
    new MovieDrop(item);
  });
}

initSeances();
document.addEventListener('DOMContentLoaded', () => Livewire.hook('morph.updated', () => {
  initSeances();
}));

function collectSeances() {
  const data = [];
  halls.forEach(hall => {
    const seances = hall.querySelectorAll('.conf-step__seances-movie');
    seances.forEach(seance => {
      /** Убедиться, что они на шкале. */
      data.push({
        hall_id: hall.dataset.id,
        movie_id: seance.dataset.id,
        start: seance.querySelector('.conf-step__seances-movie-start').innerText
      });
    });
  });
  Livewire.dispatchTo('admin.seances', 'seances-collected', [data]);
}