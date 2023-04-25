
$(".test").click(function () {
    $("#cars .car-item").remove()
})
$("#car-type").change(function () {
    const brandlist = {
        9: 'BMW',
        6: 'Audi',
        24: 'Ford',
        28: 'Honda',
        178: 'Kawasaki',
        76: 'Suzuki',
        115: 'DAF',
        175: 'Iveco',
        177: 'MAN'
    }
    const legkovieBrandlist = {
        0: 'Будь-яка',
        6: 'Audi',
        9: 'BMW',
        24: 'Ford',
        28: 'Honda',
    }
    const motoBrandlist = {
        0: 'Будь-яка',
        9: 'BMW',
        28: 'Honda',
        76: 'Suzuki',
        178: 'Kawasaki',
    }
    const truckBrandlist = {
        0: 'Будь-яка',
        24: 'Ford',
        115: 'DAF',
        175: 'Iveco',
        177: 'MAN'
    }

    let brandSelectOption = $("#brand option")
    let brandSelect = $("#brand")

    switch ($("#car-type").val()) {
        case '0':
            setBrandSelect(brandSelect, brandSelectOption, brandlist)
            break
        case '1':
            setBrandSelect(brandSelect, brandSelectOption, legkovieBrandlist)
            break
        case '2':
            setBrandSelect(brandSelect, brandSelectOption, motoBrandlist)
            break
        case '6':
            setBrandSelect(brandSelect, brandSelectOption, truckBrandlist)
            break
    }
})

function setBrandSelect (brandSelect, brandSelectOption, obj) {
    for (let [key, value] of Object.entries(obj)) {
        brandSelectOption.remove()
        brandSelect.append(`<option value="${key}">${value}</option>`)
    }
}

$("#year").change(function () {
    let from = $("#year-from")
    let to = $("#year-to")
    if (from.val() != 0 && to.val() != 0 && from.val() > to.val()) {
        let changeYear = from.val()
        from.val(to.val())
        to.val(changeYear)
    }
})

$("#price").change(function () {
    let from = $("#price-from")
    let to = $("#price-to")
    if (from.val() && to.val() && from.val() > to.val()) {
        let changePrice = from.val()
        from.val(to.val())
        to.val(changePrice)
    }
})

$("#submit").click(function () {
    $.ajax({
        url: `/autoria`,
        type: 'POST',
        dataType: 'json',
        data: {
            "_token": $('meta[name="csrf-token"]').attr('content'),
            type: $("#car-type").val(),
            brand: $("#brand").val(),
            yearFrom: $("#year-from").val(),
            yearTo: $("#year-to").val(),
            priceFrom: $("#price-from").val(),
            priceTo: $("#price-to").val()
        },
        success: function(response){
            $("#cars .car-item").remove()
            $("#cars").append(response.html)
        }
    })
})
