function paginateButton(link) {
  document.getElementById("goods_table").innerHTML = loading();
  const searchInput = document.getElementById("search");
  const keyword = searchInput.value;
  if (keyword) {
    searchGoods(link, keyword);
  } else {
    getGoods(link);
  }
  backToTop({ element: page });
}

function productCard({ data, no }) {
  const setPrice = data.goods_price;
  const price = setPrice.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
  const setName = data.goods_name;
  var name = setName.substring(0, 40);
  return `
    <tr>
      <td>
        ${no}
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

function paginateBtn(data) {
  const btnBack = document.getElementById("paginate_button");
  const textPaginate = document.getElementById("paginate_text");
  if (data.backPage) {
    btnBack.innerHTML += `<button onclick="paginateButton('${data.backPage}')" class="back">Back</button>`;
  }
  if (data.nextPage) {
    btnBack.innerHTML += `<button onclick="paginateButton('${data.nextPage}')" class="next">Next</button>`;
  }
  if (data.totalItems >= 1) {
    textPaginate.innerHTML = `
        <span>Page</span>
        <span>${data.currentPage}</span>
        <span>of</span>
        <span>${data.pageCount}</span>
        <span>(${data.totalItems} Barang)</span>
    `;
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
          var no = 1;
          result.goods.map(async (value) => {
            const listGoods = document.getElementById("goods_table");
            listGoods.innerHTML += productCard({ data: value, no: no });
            no++;
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
      goodsContainer.innerHTML = serverError();
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
      if (result && result.goods.length != 0 && result.goods.currentRow != 0) {
        setTimeout(() => {
          goodsContainer.innerHTML = "";
          paginateBtn(result);
          var no = 1;
          result.goods.map(async (value) => {
            const listGoods = document.getElementById("goods_table");
            listGoods.innerHTML += productCard({ data: value, no: no });
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
      goodsContainer.innerHTML = serverError();
    });
}
