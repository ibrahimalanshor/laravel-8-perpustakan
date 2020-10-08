$(function () {

	let dataLoan = []
	
	const reset = () => {
		const total = $('[name=total]')

		$('#make')[0].reset()
		$('[name=code]').empty()
		
		total.removeAttr('max')
		total.next('small').empty()
	}

	const addCart = data => {
		const table = $('table')

		let tr = $('<tr>', {
			'data-id': data.id
		})

		let name = $('<td>', {
			text: data.name,
			appendTo: tr
		})
		let total = $('<td>', {
			text: data.total,
			appendTo: tr
		})
		let button = $('<button>', {
			append: '<i class="fa fa-minus"></i>',
			'class': 'btn btn-danger btn-sm',
			on: {
				click: () => removeCart(data.id)
			}
		})
		let action = $('<td>', {
			append: button,
			appendTo: tr
		})

		$('#empty').hide()
		table.append(tr)
		$('#saveBtn').removeAttr('disabled')
	}

	const editCart = (id, total) => {
		let tr = $(`[data-id=${id}]`)
		let td = tr.find('td:eq(1)')

		td.html(total)
	}

	const removeCart = id => {
		let tr = $(`[data-id=${id}]`)
		let index = dataLoan.map(el => el.id).indexOf(id)

		tr.remove()
		dataLoan.splice(index, 1);

		if (dataLoan.length < 1) {
			$('#empty').show()
			$('#saveBtn').attr('disabled', '')
		}
	}

	$('[name=code]').select2({
		placeholder: 'Code',
		ajax: {
			url: getBookUrl,
			type: 'post',
			data: params => ({
				_token: token,
				code: params.term
			}),
			dataType: 'json',
			processResults: res => ({
				results: res
			}),
			cache: true
		}
	})

	$('[name=member_id]').select2({
		placeholder: 'Member',
		ajax: {
			url: getMemberUrl,
			type: 'post',
			data: params => ({
				_token: token,
				name: params.term
			}),
			dataType: 'json',
			processResults: res => ({
				results: res
			}),
			cache: true
		}
	})

	$('[name=code]').on('select2:select', e => {
		const data = e.params.data
		const name = $('[name=name]')
		const total = $('[name=total]')
		const loan = dataLoan.find(el => el.id == data.id)

		const max = loan ? data.stock - loan.total : data.stock

		name.val(data.name)
		total.attr('max', max)
		total.next('small').html(`Max ${max}`)
	})

	$('#make').submit(function (e) {
		e.preventDefault()

		const id = $('[name=code]').val()
		const name = $('[name=name]').val()
		const total = parseInt($('[name=total]').val())

		const data = {
			id: id,
			name: name,
			total: total
		}

		if (dataLoan.some(el => el.id === id)) {
			let loan = dataLoan.find(el => el.id === data.id)

			loan.total = total + loan.total

			editCart(id, loan.total);
		} else {
			dataLoan.push(data)
			addCart(data)
		}

		reset()

	})

	$('#save form').submit(function () {
		let form = $(this)

		$.each(dataLoan, function (index, item) {
			form.append(`<input type='hidden' name='book_id[]' value='${item.id}'>`)
			form.append(`<input type='hidden' name='total_id[]' value='${item.total}'>`)
		})

		return true;
	})

	reset()

	$('#saveBtn').attr('disabled', '') 
})