class IndexController
{
  constructor()
  {
    this.logoutButton = document.getElementById('logout-button');
    
    if( this.logoutButton)
      this.logoutButton.addEventListener('click', this.handleLogout.bind(this));
  }

  async handleLogout(e)
  {
    e.preventDefault();
    
    try
    {
      const response = await fetch('ajax.php?page=index&handler=logout', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-Requested-With': 'XMLHttpRequest'
        },
        credentials: 'same-origin'
      });

      const result = await response.json();
      
      if( !response.ok)
        throw new Error(result.error);

      window.location.href = '?page=auth&action=login';
    }
    catch(error)
    {
      console.error('Logout failed:', error);
    }
  }
}

document.addEventListener('DOMContentLoaded', () => {
  new IndexController();
});
