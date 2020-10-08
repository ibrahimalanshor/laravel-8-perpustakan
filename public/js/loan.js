$(function () {
	
	const table = $('table').DataTable({
		serverSide: true,
		ajax: ajaxUrl,
		columns: [
			{ data: 'DT_RowIndex' },
			{
				data: 'books',
				render: data => {
					let li = ''

					$.each(data, function (index, item) {
						li = li + `<li>${item.name} <span class="badge badge-secondary">${item.pivot.qty}</span></li>`
					})

					return `<ul class="list-unstyled mb-0">${li}</ul>`
				}
			},
			{ data: 'member.name' },
			{ data: 'return' },
			{ data: 'late' },
			{
				data: 'status',
				render: status =>  `<span class="badge badge-${status ? 'primary' : 'success'}">${status ? 'Active' : 'Returned'}</span>`
			},
			{
				render: (data, type, row) => {
					const btn = `
						<button class="btn btn-warning btn-sm" data-click="return" title="Return" ${row.status ? '' : 'disabled'}><i class="fa fa-undo"></i></button>
						<button class="btn btn-info btn-sm" data-click="extend" title="Extend" ${row.status ? '' : 'disabled'}><i class="fa fa-calendar"></i></button>
						<button class="btn btn-danger btn-sm" data-click="delete" title="Delete"><i class="fa fa-trash"></i></button>
					`

					return btn
				},
				orderable: false,
				searchable: false,
			},
			{
				data: 'return_date',
				visible: false
			}
		]
	})

	const reload = () => table.ajax.reload()

	const returnBook = data => {
		const modal = $('#return')

		let url = returnUrl.replace(':id', data.id)

		modal.find('form').attr('action', url)
		modal.find('[name=late]').val(data.late)
		modal.find('[name=fine]').val(data.late * 1000)

		modal.modal('show')
	}

	const extend = data => {
		const modal = $('#extend')

		let url = extendUrl.replace(':id', data.id)

		modal.find('form').attr('action', url)
		modal.find('input').attr('min', data.return_date)

		modal.modal('show')
	}

	const remove = data => {
		let url = deleteUrl.replace(':id', data.id)

		$.ajax({
			url: url,
			type: 'post',
			data: {
				'_method': 'delete',
				'_token': csrf
			},
			dataType: 'json',
			success: res => {
				let msg = `<div class="alert alert-success alert-dismissible">${res.msg}<button class="close" data-dismiss="alert">&times;</button></div>`
				
				$('#alert').html(msg)
				reload()
			}
		})
	} 

	$('tbody').on('click', 'button', function () {
		const data = table.row($(this).parents('tr')).data()
		const action = $(this).data('click')

		switch (action) {
			case 'return':
				returnBook(data)

				break;

			case 'extend':
				extend(data)

				break;

			case 'delete':
				confirm('Delete ?') ? remove(data) : ''
		}
	})

	$('#return form').submit(function (e) {
		e.preventDefault()	

		$.ajax({
			url: this.action,
			type: 'post',
			data: {
				'_method': 'patch',
				'_token': csrf
			},
			dataType: 'json',
			success: res => {
				let msg = `<div class="alert alert-success alert-dismissible">${res.msg}<button class="close" data-dismiss="alert">&times;</button></div>`
				
				$('#alert').html(msg)
				reload()
				$('#return').modal('hide')
			}
		})
	})

	$('#extend form').submit(function (e) {
		e.preventDefault()

		let date = $(this).find('input').val()

		$.ajax({
			url: this.action,
			type: 'post',
			data: {
				'_method': 'patch',
				'_token': csrf,
				'date': date
			},
			dataType: 'json',
			success: res => {
				let msg = `<div class="alert alert-success alert-dismissible">${res.msg}<button class="close" data-dismiss="alert">&times;</button></div>`
				
				$('#alert').html(msg)
				reload()
				$('#extend').modal('hide')
			}
		})
	})

	$('[data-filter=member]').on('keyup change', function () {
		const column = table.column(2)

		column.search(this.value).draw()
	})

	$('[data-filter=return]').on('keyup change', function () {
		const column = table.column(7)

		column.search(this.value).draw()
	})

	$('[data-filter=status]').on('change', function () {
		const column = table.column(5)
		
		column.search(this.value).draw()
	})

	$('#filter').find('form')[0].reset()

})