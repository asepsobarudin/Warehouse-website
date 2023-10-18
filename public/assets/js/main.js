function backToTop() {
  page.scrollTo({
    top: 0,
    behavior: "smooth",
  });
  window.scrollTo({
    top: 0,
    behavior: "smooth",
  });
}

function paginateButton(link) {
  document.getElementById("goods_table").innerHTML = loading();
  const searchInput = document.getElementById("search");
  const keyword = searchInput.value;
  if (keyword) {
    searchGoods(link, keyword);
  } else {
    getGoods(link);
  }
  backToTop();
}

function generateQRCode(data) {
  const qr = qrcode(0, "L");
  qr.addData(data);
  qr.make();
  return qr.createDataURL(8); // Sesuaikan ukuran QR code jika diperlukan
}

function productCard(data) {
  const setPrice = data.goods_price;
  const price = setPrice.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");

  const setName = data.goods_name;
  var name = setName.substring(0, 40);

  return `
    <tr>
      <td>
        <div class="qrcode">
          <div>
            <img src="${generateQRCode(
              baseURL + "goods_detail/" + data.goods_code
            )}" alt="${data.goods_code}">
          </div>
          <span>${data.goods_code}</span>
        </div>
      </td>
      <td>
      <a href="${baseURL + "goods_detail/" + data.goods_code}">${name}</a>
      </td>
      <td>${data.goods_stok_toko}</td>
      <td>Rp. ${price}</td>
      <td>
        <div>
          <button onclick="addCart('${data.goods_code}')">
            <img src="${baseURL}/assets/icons/shopping-cart-line-white.svg" width="30" heigth="30" style="stroke:#ffff" />
          </button>
        </div>
      </td>
    </tr>`;
}

function loading() {
  document.getElementById("paginate_button").innerHTML = "";
  document.getElementById("paginate_text").innerHTML = "";
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

function paginateBtn(data) {
  const btnBack = document.getElementById("paginate_button");
  if (data.backPage) {
    btnBack.innerHTML += `<button onclick="paginateButton('${data.backPage}')" class="back">Back</button>`;
  }
  if (data.nextPage) {
    btnBack.innerHTML += `<button onclick="paginateButton('${data.nextPage}')" class="next">Next</button>`;
  }

  const textPaginate = document.getElementById("paginate_text");
  if (data.totalItems >= 1) {
    textPaginate.innerHTML = `
        <span>Page</span>
        <span>${data.currentPage}</span>
        <span>of</span>
        <span>${data.pageCount}</span>
        <span>(${data.totalItems} Barang)</span>
    `;
  }

  if (data.totalItems == 0) {
    document.getElementById("goods_table").innerHTML = "Tidak Ada Barang!";
  }
}

async function getGoods(url) {
  goodsContainer.innerHTML = loading();
  fetch(url + "/product", {
    method: "GET",
  })
    .then(async (response) => response.json())
    .then((result) => {
      if (result && result.goods.length != 0) {
        setTimeout((async) => {
          goodsContainer.innerHTML = "";
          paginateBtn(result);
          result.goods.map(async (value) => {
            const listGoods = document.getElementById("goods_table");
            listGoods.innerHTML += productCard(value);
          });
        }, 1000);
      } else {
        goodsContainer.innerHTML = `
        <tr>
          <td colspan="5" >
            <div class="loading">
              <h2>Tidak Ada Barang</h2>
            </div>
          </td>
        </tr>
        `;
      }
    })
    .catch((errors) => {
      goodsContainer.innerHTML = `
      <tr>
        <td colspan="5">
          <div class="loading">
            <h2>Server Error 500</h2>
            <p>Silahkan Periksa Kembali Konksi Internet!</p>
          </div>
        </td>
      </tr>
    `;
    });
}

async function searchGoods(url, key) {
  const dataToSend = { search: key };
  fetch(url, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(dataToSend),
  })
    .then(async (response) => response.json())
    .then(async (result) => {
      if (result && result.goods.length != 0) {
        setTimeout(() => {
          goodsContainer.innerHTML = "";
          paginateBtn(result);
          result.goods.map(async (value) => {
            const listGoods = document.getElementById("goods_table");
            listGoods.innerHTML += productCard(value);
          });
        }, 1000);
      } else {
        document.getElementById("paginate_text").innerHTML = "";
        document.getElementById("paginate_button").innerHTML = "";
        goodsContainer.innerHTML = `
        <tr>
          <td colspan="5" >
            <div class="loading">
              <h2>Barang tidak ditemuken!</h2>
            </div>
          </td>
        </tr>
        `;
      }
    })
    .catch((error) => {
      console.error(error);
    });
}
