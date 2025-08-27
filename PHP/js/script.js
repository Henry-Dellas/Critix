document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll(".estrelas").forEach(div => {
    const nota = parseFloat(div.dataset.nota) || 0;
    
    // Limpa qualquer conteúdo existente
    div.innerHTML = '';
    
    // Adiciona as 5 estrelas
    for (let i = 1; i <= 5; i++) {
      const img = document.createElement('img');
      img.className = 'estrela';
      img.alt = i <= nota ? '★' : '☆';
      
      if (nota >= i) {
        img.src = 'imagens/estrelinhas/estrela_cheia.svg';
      } else if (nota >= i - 0.5) {
        img.src = 'imagens/estrelinhas/estrela_meia.svg';
      } else {
        img.src = 'imagens/estrelinhas/estrela_vazia.svg';
      }
      
      div.appendChild(img);
    }
  });
  // Tabs de comentários (efeito visual)
  document.querySelectorAll(".tab-btn").forEach(btn=>{
    btn.addEventListener("click", ()=>{
      document.querySelectorAll(".tab-btn").forEach(b=>b.classList.remove("ativo"));
      btn.classList.add("ativo");
    });
  });
});
