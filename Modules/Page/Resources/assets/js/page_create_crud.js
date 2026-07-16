crud.field('name').onChange(field => {
    crud.field('title').input.value = field.value;
});