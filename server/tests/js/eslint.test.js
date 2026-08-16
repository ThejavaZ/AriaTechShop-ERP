describe('CI/CD - Validacion de calidad de codigo', () => {

    test('pipeline detecta uso de var en lugar de const/let', () => {
        const tieneVar = (code) => code.includes('var ')
        expect(tieneVar('var x = 1')).toBe(true)
        expect(tieneVar('const x = 1')).toBe(false)
    })

    test('pipeline detecta variables no utilizadas', () => {
        const variables = ['x', 'y']
        const usadas = ['x']
        const noUsadas = variables.filter(v => !usadas.includes(v))
        expect(noUsadas).toContain('y')
    })

})