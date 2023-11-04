function backToTop({ element }) {
  element.scrollTo({
    top: 0,
    behavior: "smooth",
  });
  window.scrollTo({
    top: 0,
    behavior: "smooth",
  });
}

function serverError() {
  return `
    <tr>
      <td colspan="5">
        <div class="loading">
          <h2>Server Error 500</h2>
          <p>Silahkan Periksa Kembali Konksi Internet!</p>
        </div>
      </td>
    </tr>
  `;
}

function loading() {
  const pgButton = document.getElementById("paginate_button");
  const pgText = document.getElementById("paginate_text");
  pgButton.innerHTML = "";
  pgText.innerHTML = "";
  return `
  <tr>
    <td colspan="5" class="tdLoading">
      <div class="loading">
        <img src="${baseURL}/assets/icons/loader-4-line.svg" alt="loading" class="spiner">
        <p>Loading...</p>
      </div>
    </td>
  </tr>`;
}
