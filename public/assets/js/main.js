function tableFiled({ data, no }) {
  const setPrice = data.goods_price;
  const price = setPrice.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
  return `
    <tr>
      <td>
        ${no}
      </td>
      <td>
        ${data.goods_name}
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

async function getGoods({ url }) {
  csTable.innerHTML = tableLoading({
    col: 5,
    element: ["paginate_button", "paginate_text"],
  });
  const result = await get({ url: url });

  if (result.code) {
    csTable.innerHTML = tableError({ col: 5, code: result.code });
  }

  if (result && result.goods.length != 0) {
    setTimeout((async) => {
      csTable.innerHTML = "";
      paginateBtn({data: result, table: csTable, col: 5});
      var no = 1;
      result.goods.map(async (value) => {
        csTable.innerHTML += tableFiled({ data: value, no: no });
        no++;
      });
    }, 1000);
  } else {
    csTable.innerHTML = `
    <tr>
      <td colspan="5" >
        <div class="tbLoading">
          <h2>Tidak Ada Barang</h2>
        </div>
      </td>
    </tr>
    `;
  }
}

async function csSearch({ url }) {
  csTable.innerHTML = tableLoading({
    col: 5,
    element: ["paginate_button", "paginate_text"],
  });
  const key = document.getElementById("cs_input_search").value;
  const data = { search: key };

  if (key) {
    const result = await post({ url: url, data: data });
    if (result && result.goods.length != 0 && result.goods.currentRow != 0) {
      setTimeout(() => {
        csTable.innerHTML = "";
        paginateBtn({data: result, table: csTable, col: 5});
        var no = 1;
        result.goods.map(async (value) => {
          csTable.innerHTML += tableFiled({ data: value, no: no });
          no++;
        });
      }, 1000);
    } else {
      csTable.innerHTML = `
        <tr>
          <td colspan="5" >
            <div class="tbLoading">
              <h2>Barang tidak ditemukan!</h2>
            </div>
          </td>
        </tr>
        `;
    }
  } else {
    getGoods({ url: `${baseURL}goods/goods_list` });
  }
}
