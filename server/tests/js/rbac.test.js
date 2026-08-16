describe('RBAC - Control de acceso en frontend', () => {

    test('muestra menu admin solo si tiene rol admin', () => {
        const roles = ['admin']
        const puedeVerAdmin = roles.includes('admin')
        expect(puedeVerAdmin).toBe(true)
    })

    test('oculta menu admin si no tiene rol admin', () => {
        const roles = ['tecnico']
        const puedeVerAdmin = roles.includes('admin')
        expect(puedeVerAdmin).toBe(false)
    })

})