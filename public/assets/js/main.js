function productCard(image, nameGoods, price, storeStok, kodeGoods) {
  return `<div class="product_card">
            <img src="${image}/assets/images/image1.jpeg" alt="image">
            <div class="card_text">
              <a href="#">${nameGoods}</a>
              <div>
                <span>${price}</span>
                <span>/${storeStok}</span>
              </div>
            </div>
            <button onclick="addCart('${kodeGoods}')">
              <img src="${image}/assets/icons/add_cart.png" alt="add_cart">
            </button>
          </div>`;
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

async function paginate(link, image) {
  try {
    const response = await fetch(link + "/product");

    if (!response.ok) {
      throw new Error("Error Network");
    }

    const data = await response.json();

    if (!data || !data.length) {
      document.getElementById("product_container").innerHTML =
        "Data tidak ditemukan ";
    }

    if (data.code != 404) {
      document.getElementById("product_container").innerHTML = "";

      data.goods.map(async (list) => {
        const productCon = document.getElementById("product_container");
        productCon.innerHTML += productCard(
          image,
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
        false
      );
    }
  } catch (error) {
    document.getElementById("product_container").innerHTML = "Server Error 500";
  }
}

function Search(link, image, keyword) {
  const dataToSend = { search: keyword };
  fetch(link, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(dataToSend),
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.goods.length != 0) {
        document.getElementById("product_container").innerHTML = "";
        data.goods.map(async (list) => {
          const productCon = document.getElementById("product_container");
          productCon.innerHTML += productCard(
            image,
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
      } else {
        document.getElementById("product_container").innerHTML =
          "Data tidak ditemukan";
        document.getElementById("paginate_button").innerHTML = "";
        document.getElementById("paginate_text").innerHTML = "";
      }
    })
    .catch((error) => {
      console.error(error);
    });
}
