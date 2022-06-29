<style>
    .side-navbar {
  width: 180px;
  height: 100%;
  position: fixed;
  margin-left: -300px;
  background-color: #100901;
  transition: 0.5s;
}
.nav-link:active,
.nav-link:focus,
.nav-link:hover {
  background-color: #ffffff26;
}
.my-container {
  transition: 0.4s;
}
.active-nav {
  margin-left: 0;
}
/* for main section */
.active-cont {
  margin-left: 180px;
}
#menu-btn {
  background-color: #100901;
  color: #fff;
  margin-left: -62px;
}
</style>

<div class="side-navbar active-nav d-flex justify-content-between flex-wrap flex-column" id="sidebar">
    <ul class="nav flex-column text-white w-100">
      <a href="#" class="nav-link h3 text-white my-2">
        Side Nav
      </a>
      <li href="#" class="nav-link">
        <span class="mx-2">Home</span>
      </li>
      <li href="#" class="nav-link">
        <span class="mx-2">About</span>
      </li>
      <li href="#" class="nav-link">
        <span class="mx-2">Contact</span>
      </li>
    </ul>
</div>
