const Sidebar = ( top, bottom ) => (
        `
        <div class="scroll-wrapper">
        ${ top }
        <div class="scroll-inner">
            ${ bottom }
        </div>
        </div>
        `
)

export default Sidebar