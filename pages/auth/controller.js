class AuthController
{
  constructor()
  {
    this.loginForm = document.getElementById('login-form');
    this.registerForm = document.getElementById('register-form');
    this.errorMessage = document.getElementById('error-message');

    if( this.loginForm)
      this.loginForm.addEventListener('submit', this.handleLogin.bind(this));
    
    if( this.registerForm)
      this.registerForm.addEventListener('submit', this.handleRegister.bind(this));
  }

  async handleLogin(e)
  {
    e.preventDefault();
    
    const formData = new FormData(this.loginForm);
    const data = {
      username: formData.get('username'),
      password: formData.get('password')
    };

    try
    {
      const response = await fetch('ajax.php?page=auth&handler=login', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify(data)
      });

      const result = await response.json();
      
      if( !response.ok)
        throw new Error(result.error);

      window.location.href = '?page=index';
    }
    catch(error)
    {
      this.showError(error.message);
    }
  }

  async handleRegister(e)
  {
    e.preventDefault();
    
    const formData = new FormData(this.registerForm);
    const data = {
      username: formData.get('username'),
      password: formData.get('password')
    };

    try
    {
      const response = await fetch('ajax.php?page=auth&handler=register', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify(data)
      });

      const result = await response.json();
      
      if( !response.ok)
        throw new Error(result.error);

      window.location.href = '?page=auth&action=login';
    }
    catch(error)
    {
      this.showError(error.message);
    }
  }

  showError(message)
  {
    this.errorMessage.textContent = message;
    this.errorMessage.classList.remove('d-none');
  }
}

new AuthController();
