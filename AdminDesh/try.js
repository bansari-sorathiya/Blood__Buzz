function toggleBloodGroupInputs() {
    const bloodGroupInputs = document.getElementById('bloodGroupInputs');
    const insertBtn = document.getElementById('insertBtn');
    const submitBtn = document.querySelector('form button[type="submit"]');
    
    bloodGroupInputs.style.display = 'block';
    insertBtn.style.display = 'none';
    submitBtn.style.display = 'inline-block';
  }
  
  function cancelBloodGroup() {
    const bloodGroupInputs = document.getElementById('bloodGroupInputs');
    const insertBtn = document.getElementById('insertBtn');
    const submitBtn = document.querySelector('form button[type="submit"]');
    
    bloodGroupInputs.style.display = 'none';
    insertBtn.style.display = 'inline-block';
    submitBtn.style.display = 'none';
  }
  