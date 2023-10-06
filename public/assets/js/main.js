function productCard(image, nameGoods, price, storeStok, kodeGoods) {
  return `<div class="product_card">
            <div class="con_image">
              <img src="${image}/assets/images/image1.jpeg" alt="image" class="images">
            </div>
            <div class="card_text">
              <a href="#">${nameGoods}</a>
              <div>
                <span>Rp. ${price}</span>
                <span>(${storeStok})</span>
              </div>
            </div>
            <button onclick="addCart('${kodeGoods}')">
              <img src="${image}/assets/icons/add_cart.png" alt="add_cart">
            </button>
          </div>`;
}

function loading() {
  document.getElementById("paginate_button").innerHTML = "";
  document.getElementById("paginate_text").innerHTML = "";
  return `<dialog open class="dialog_loading">
  <img src="${baseURL}assets/icons/loading.png" alt="loading" class="loading">
</dialog>`;
}

function paginateBtn(
  backPage,
  nextPage,
  currentPage,
  pageCount,
  totalItems,
  keyword
) {
  const btnBack = document.getElementById("paginate_button");

  if (keyword) {
    if (backPage && nextPage) {
      btnBack.innerHTML = `<button onclick="paginateSearchBtn('${backPage}')" class="back">Back</button>`;
      btnBack.innerHTML += `<button onclick="paginateSearchBtn('${nextPage}')" class="next">Next</button>`;
    } else if (backPage) {
      btnBack.innerHTML = `<button onclick="paginateSearchBtn('${backPage}')" class="back">Back</button>`;
    } else if (nextPage) {
      btnBack.innerHTML = `<button onclick="paginateSearchBtn('${nextPage}')" class="next">Next</button>`;
    }
  } else {
    if (backPage && nextPage) {
      btnBack.innerHTML = `<button onclick="paginateButton('${backPage}')" class="back">Back</button>`;
      btnBack.innerHTML += `<button onclick="paginateButton('${nextPage}')" class="next">Next</button>`;
    } else if (backPage) {
      btnBack.innerHTML = `<button onclick="paginateButton('${backPage}')" class="back">Back</button>`;
    } else if (nextPage) {
      btnBack.innerHTML = `<button onclick="paginateButton('${nextPage}')" class="next">Next</button>`;
    }
  }

  const textPaginate = document.getElementById("paginate_text");
  textPaginate.innerHTML = `
        <span>Page</span>
        <span>${currentPage}</span>
        <span>of</span>
        <span>${pageCount}</span>
        <span>(${totalItems} Barang)</span>
    `;
}

async function paginate(link) {
  document.getElementById("product_container").innerHTML = loading();
  try {
    const response = await fetch(link + "/product");

    if (!response.ok) {
      throw new Error("Error Network");
    }

    const data = await response.json();

    if (data) {
      setTimeout(() => {
        document.getElementById("product_container").innerHTML = "";
        data.goods.map(async (list) => {
          const price = list.price;
          const idr = price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
          const productCon = document.getElementById("product_container");
          productCon.innerHTML += productCard(
            baseURL,
            list.name_goods,
            idr,
            list.store_stok,
            list.kode_goods
          );
        });

        paginateBtn(
          data.backPage,
          data.nextPage,
          data.currentPage,
          data.pageCount,
          data.totalItems,
          false
        );
      }, 1000);
    }
  } catch (error) {
    document.getElementById("product_container").innerHTML = "Server Error 500";
  }
}

function Search(link, keyword) {
  const dataToSend = { search: keyword };
  fetch(link, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(dataToSend),
  })
    .then(async (response) => response.json())
    .then(async (data) => {
      if (data && data.goods.length != 0) {
        setTimeout(async () => {
          document.getElementById("product_container").innerHTML = "";
          data.goods.map(async (list) => {
            const productCon = document.getElementById("product_container");
            productCon.innerHTML += productCard(
              baseURL,
              list.name_goods,
              list.price,
              list.store_stok,
              list.kode_goods
            );
          });
          paginateBtn(
            data.backPage,
            data.nextPage,
            data.currentPage,
            data.pageCount,
            data.totalItems,
            true
          );
        }, 1000);
      } else {
        document.getElementById("product_container").innerHTML =
          "Barang Tidak Ada";
        document.getElementById("paginate_button").innerHTML = "";
        document.getElementById("paginate_text").innerHTML = "";
      }
    })
    .catch((error) => {
      console.error(error);
    });
}
