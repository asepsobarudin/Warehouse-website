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
  document.getElementById("goods_container").innerHTML = loading();
  const searchInput = document.getElementById("search");
  const keyword = searchInput.value;
  if (keyword) {
    searchGoods(link, keyword);
  } else {
    getGoods(link);
  }
  backToTop();
}

function productCard(data) {
  const setPrice = data.goods_price;
  const price = setPrice.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");

  const setName = data.goods_name;
  var name = setName.substring(0, 40);
  const images = data.goods_images;
  console.log(images);
  if (name.length >= 30) {
    name = name + "...";
  }
  if (!images) {
    images = "dummyimages.jpg";
  }
  return `
  <div class="product_card">
    <div class="con_image">
      <img src="${baseURL}/assets/images/uploads/${data.goods_images}" alt="image" class="images">
    </div>
    <div class="card_text">
      <a href="${baseURL}goods_detail/${data.goods_code}">${name}</a>
        <div>
          <span>Rp. ${price}</span>
          <span>Tersedia | ${data.goods_stok}</span>
        </div>
        </div>
          <button onclick="addCart('${data.goods_code}')">
            <img src="${baseURL}/assets/icons/add_cart.png" alt="add_cart">
        </button>
    </div>`;
}

function loading() {
  document.getElementById("paginate_button").innerHTML = "";
  document.getElementById("paginate_text").innerHTML = "";
  return `
    <div class="loading">
      <img src="${baseURL}assets/icons/loading.png" alt="loading" class="spiner">
      <p>Loading...</p>
    </div>
  `;
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
    document.getElementById("goods_container").innerHTML = "Tidak Ada Barang!";
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
        setTimeout(() => {
          goodsContainer.innerHTML = "";
          paginateBtn(result);
          result.goods.map(async (value) => {
            const listGoods = document.getElementById("goods_container");
            listGoods.innerHTML += productCard(value);
          });
        }, 1000);
      } else {
        goodsContainer.innerHTML = `
        <div class="loading">
          <h2>Tidak Ada Barang</h2>
        </div>
        `;
      }
    })
    .catch((errors) => {
      goodsContainer.innerHTML = `
      <div class="loading">
        <h2>Server Error 500</h2>
        <p>Silahkan Periksa Kembali Konksi Internet!</p>
      </div>
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
            const listGoods = document.getElementById("goods_container");
            listGoods.innerHTML += productCard(value);
          });
        }, 1000);
      } else {
        document.getElementById("paginate_text").innerHTML = "";
        document.getElementById("paginate_button").innerHTML = "";
        goodsContainer.innerHTML = `
        <div class="loading">
          <h2>Tidak Ada Barang</h2>
        </div>
        `;
      }
    })
    .catch((error) => {
      console.error(error);
    });
}
