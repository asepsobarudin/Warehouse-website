async function postRestock({ restock, goods, qty }) {
  const dataToSend = {
    restock: restock,
    goods: goods,
    qty: qty,
  };
  const url = `${baseURL}restock/add_goods`;

  try {
    const response = await fetch(url, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(dataToSend),
    });

    if (!response.ok) {
      console.error(`Network response not OK. Status code: ${response.status}`);
      const responseBody = await response.text();
      console.error(`Response body: ${responseBody}`);
      throw new Error('Network response was not ok');
    }

    const result = await response.json();
    console.log(result);
  } catch (error) {
    console.error(error)
  }
}

async function getRestock() {
  const url = `${baseURL}restock_list/`;
  fetch(url, {
    method: "GET",
  })
    .then(async (response) => response.json())
    .then(async (result) => {
      console.log(result);
    })
    .catch((error) => {
      console.error();
    });
}

function cardRestock({ no, title, qty, noGC, noRst }) {
  return `
    <div class="cart_restock">
      <div>
        <h2>${no}.</h2>
        <h2>${title}</h2>
      </div>
      <div>
        <label for="qty">
          <input type="number" id="qty" value="${qty}">
        </label>
        <button>
          <img src="${baseURL}assets/icons/subtract-line.svg" alt="substract-line">
        </button>
      </div>
    </div>
  `;
}
