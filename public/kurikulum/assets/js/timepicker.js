class TimePicker {
  constructor(input) {
    this.input = input;
    this.input.placeholder = 'HH:MM (contoh: 07:30)';
    this.createButton();
    this.createPicker();
    this.input.addEventListener('input', (e) => this.formatInput(e));
  }

  createButton() {
    const wrapper = document.createElement('div');
    wrapper.style.position = 'relative';
    wrapper.style.display = 'inline-block';
    wrapper.style.width = '100%';
    
    this.input.parentNode.insertBefore(wrapper, this.input);
    wrapper.appendChild(this.input);
    
    const btn = document.createElement('button');
    btn.type = 'button';
    btn.className = 'timepicker-toggle';
    btn.innerHTML = '🕐';
    btn.onclick = (e) => {
      e.preventDefault();
      e.stopPropagation();
      this.show();
    };
    wrapper.appendChild(btn);
  }

  formatInput(e) {
    let val = e.target.value.replace(/[^0-9:]/g, '');
    const parts = val.split(':');
    if (parts[0] && parts[0].length > 2) {
      val = parts[0].slice(0, 2) + ':' + parts[0].slice(2);
    }
    e.target.value = val.slice(0, 5);
  }

  createPicker() {
    this.picker = document.createElement('div');
    this.picker.className = 'timepicker-dropdown';
    this.picker.innerHTML = `
      <div class="timepicker-header">Pilih Waktu</div>
      <div class="timepicker-body">
        <div class="timepicker-col">
          <div class="timepicker-scroll" id="hours-${this.input.id}"></div>
        </div>
        <div class="timepicker-sep">:</div>
        <div class="timepicker-col">
          <div class="timepicker-scroll" id="minutes-${this.input.id}"></div>
        </div>
      </div>
      <div class="timepicker-footer">
        <button type="button" class="timepicker-btn" onclick="this.closest('.timepicker-dropdown').timepicker.cancel()">Batal</button>
        <button type="button" class="timepicker-btn timepicker-btn-primary" onclick="this.closest('.timepicker-dropdown').timepicker.confirm()">OK</button>
      </div>
    `;
    this.picker.timepicker = this;
    document.body.appendChild(this.picker);

    const hoursDiv = document.getElementById(`hours-${this.input.id}`);
    const minutesDiv = document.getElementById(`minutes-${this.input.id}`);

    for (let i = 0; i < 24; i++) {
      const div = document.createElement('div');
      div.className = 'timepicker-item';
      div.textContent = String(i).padStart(2, '0');
      div.onclick = () => this.selectHour(i);
      hoursDiv.appendChild(div);
    }

    for (let i = 0; i < 60; i += 5) {
      const div = document.createElement('div');
      div.className = 'timepicker-item';
      div.textContent = String(i).padStart(2, '0');
      div.onclick = () => this.selectMinute(i);
      minutesDiv.appendChild(div);
    }

    document.addEventListener('click', (e) => {
      if (!this.picker.contains(e.target) && e.target !== this.input) {
        this.hide();
      }
    });
  }

  show() {
    const rect = this.input.getBoundingClientRect();
    this.picker.style.display = 'block';
    this.picker.style.top = rect.bottom + window.scrollY + 5 + 'px';
    this.picker.style.left = rect.left + window.scrollX + 'px';

    const val = this.input.value || '07:00';
    const [h, m] = val.includes(':') ? val.split(':') : ['07', '00'];
    this.selectedHour = parseInt(h) || 7;
    this.selectedMinute = parseInt(m) || 0;
    this.updateSelection();
  }

  hide() {
    this.picker.style.display = 'none';
  }

  selectHour(h) {
    this.selectedHour = h;
    this.updateSelection();
  }

  selectMinute(m) {
    this.selectedMinute = m;
    this.updateSelection();
  }

  updateSelection() {
    const hoursDiv = document.getElementById(`hours-${this.input.id}`);
    const minutesDiv = document.getElementById(`minutes-${this.input.id}`);
    
    hoursDiv.querySelectorAll('.timepicker-item').forEach((el, i) => {
      el.classList.toggle('selected', i === this.selectedHour);
    });
    
    minutesDiv.querySelectorAll('.timepicker-item').forEach((el, i) => {
      el.classList.toggle('selected', i * 5 === this.selectedMinute);
    });
  }

  confirm() {
    this.input.value = `${String(this.selectedHour).padStart(2, '0')}:${String(this.selectedMinute).padStart(2, '0')}`;
    this.hide();
  }

  cancel() {
    this.hide();
  }
}

document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.timepicker-input').forEach(input => {
    new TimePicker(input);
  });
});
